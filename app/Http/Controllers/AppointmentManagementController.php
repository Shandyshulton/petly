<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AppointmentManagementController extends Controller
{
    public function index(Request $request)
    {
        $appointments = Appointment::with('user')
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('appointment_id', $search)
                        ->orWhere('service_type', 'like', "%{$search}%")
                        ->orWhere('pet_name', 'like', "%{$search}%")
                        ->orWhere('pet_species', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($query) => $query->where('username', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('service_type'), fn ($query) => $query->where('service_type', $request->service_type))
            ->when($request->filled('date_from'), fn ($query) => $query->whereDate('appointment_date', '>=', $request->input('date_from')))
            ->when($request->filled('date_to'), fn ($query) => $query->whereDate('appointment_date', '<=', $request->input('date_to')))
            ->latest('appointment_date')
            ->paginate(12)
            ->withQueryString();

        return view('admin.appointment', [
            'appointments' => $appointments,
            'filters' => $request->only(['q', 'status', 'service_type', 'date_from', 'date_to']),
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'completed', 'cancelled'])],
        ]);

        $appointment = Appointment::findOrFail($id);

        DB::transaction(function () use ($appointment, $request) {
            $oldStatus = $appointment->status;
            $appointment->status = $request->status;
            $appointment->save();

            // Return the slot quota when an appointment is cancelled.
            if ($oldStatus !== 'cancelled' && $request->status === 'cancelled') {
                AppointmentSlot::where('service_type', $appointment->service_type)
                    ->where('appointment_date', $appointment->appointment_date)
                    ->where('appointment_time', $appointment->appointment_time)
                    ->where('booked_count', '>', 0)
                    ->decrement('booked_count');
            }
        });

        return back()->with('success', 'Appointment #' . $appointment->appointment_id . ' status updated to ' . $request->status . '.');
    }
}
