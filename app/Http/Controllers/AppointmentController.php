<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function create()
    {
        $user = null;
        $myAppointments = collect();

        if (session()->has('api_token')) {
            $user = User::find(session('user_id'));

            $myAppointments = Appointment::where('user_user_id', session('user_id'))
                ->where('appointment_date', '>=', now()->toDateString())
                ->whereNotIn('status', ['cancelled'])
                ->latest()
                ->get();
        }

        $slots = AppointmentSlot::select('service_type', 'appointment_date', 'appointment_time', 'booked_count', 'capacity')
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->get()
            ->groupBy(fn ($slot) => $slot->service_type . '|' . $slot->appointment_date . '|' . $slot->appointment_time)
            ->mapWithKeys(fn ($group) => [$group->first()->service_type . '|' . $group->first()->appointment_date . '|' . $group->first()->appointment_time => $group->first()]);

        return view('services', [
            'user' => $user,
            'slots' => $slots,
            'myAppointments' => $myAppointments,
        ]);
    }

    public function store(Request $request)
    {
        if (!session()->has('api_token')) {
            // Keep the filled form so the user lands back with their input intact
            session()->flash('appointment_input', $request->except('_token'));

            return redirect()
                ->route('login', ['redirect' => 'services'])
                ->with('failed', 'Please login before booking an appointment.');
        }

        $validator = Validator::make($request->all(), [
            'service_type' => ['required', Rule::in(['grooming', 'clinic'])],
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|string|max:20',
            'pet_name' => 'required|string|max:255',
            'pet_species' => 'required|string|max:100',
            'pet_breed' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $serviceType = $request->service_type;
        $date = $request->appointment_date;
        $time = $request->appointment_time;

        try {
            $appointment = DB::transaction(function () use ($serviceType, $date, $time) {
                // Ensure the slot row exists (idempotent, so concurrent creates don't duplicate)
                $slot = AppointmentSlot::firstOrCreate(
                    [
                        'service_type' => $serviceType,
                        'appointment_date' => $date,
                        'appointment_time' => $time,
                    ],
                    [
                        'capacity' => config('appointment.capacity', 5),
                        'booked_count' => 0,
                    ]
                );

                // Lock the slot row for the rest of the transaction so concurrent
                // requests queue up instead of both reading the same booked_count.
                $slot = AppointmentSlot::whereKey($slot->slot_id)->lockForUpdate()->first();

                if ($slot->booked_count >= $slot->capacity) {
                    throw new \RuntimeException('Slot is already full.');
                }

                $slot->increment('booked_count');

                return Appointment::create([
                    'user_user_id' => session('user_id'),
                    'service_type' => $serviceType,
                    'appointment_date' => $date,
                    'appointment_time' => $time,
                    'pet_name' => request('pet_name'),
                    'pet_species' => request('pet_species'),
                    'pet_breed' => request('pet_breed'),
                    'notes' => request('notes'),
                ]);
            });
        } catch (\RuntimeException $e) {
            return back()
                ->withInput()
                ->with('failed', 'Sorry, that time slot is already fully booked. Please pick another time.');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('failed', 'Something went wrong while booking. Please try again.');
        }

        return redirect()
            ->route('history', ['tab' => 'appointment'])
            ->with('success', 'Appointment booked successfully.');
    }
}
