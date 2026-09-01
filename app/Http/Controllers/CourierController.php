<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\User;
use App\Support\ProfileImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CourierController extends Controller
{
    public function getCourier()
    {
        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)
                    ->get(config('services.petly_api.url') . '/api/courier/delivery_unknown');
        
        $data = $response->json();
        return view('/courier/parcelTracking', [
            'couriers' => $data['data'] ?? [],
        ]);
    }  

    public function finish(Request $request)
    {
        $apiToken = session('api_token');
        $courierID = session('user_id');
        Http::withToken($apiToken)
            ->post(config('services.petly_api.url') . '/api/courier/delivery', [
                'courier_id' => $courierID,
                'delivery_id' => $request->delivery_id,
            ]);

        return back()->with('success');
    }

    public function getDelivery()
    {
        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)
                    ->get(config('services.petly_api.url') . '/api/courier/delivery_courier');
        
        $data = $response->json();

        $courier = User::with('courierDetails')
            ->where('role_role_id', 2)
            ->find(session('user_id'));

        return view('/courier/courierInfo', [
            'couriers' => $data['data'] ?? [],
            'courier' => $courier,
        ]);
    }

    public function updatePhoto(Request $request)
    {
        $user = User::where('role_role_id', 2)->findOrFail(session('user_id'));

        $validated = $request->validate([
            'profile_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10000'],
        ]);

        $user->profile_image = app(ProfileImageService::class)
            ->store($request->file('profile_image'), $user->profile_image);

        $user->save();

        session(['profile_image' => $user->profile_image]);

        return back()->with('success', 'Profile photo updated successfully.');
    }

    public function updateProfile(Request $request)
    {
        $user = User::where('role_role_id', 2)->findOrFail(session('user_id'));

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'vehicle_name' => ['nullable', 'string', 'max:255'],
            'plate_number' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10000'],
        ]);

        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_image')) {
            $user->profile_image = app(ProfileImageService::class)
                ->store($request->file('profile_image'), $user->profile_image);
        }

        $user->save();

        Courier::updateOrCreate(
            ['user_user_id' => $user->user_id],
            [
                'status' => 'active',
                'vehicle_name' => $validated['vehicle_name'] ?? null,
                'plate_number' => $validated['plate_number'] ?? null,
            ]
        );

        session([
            'username' => $user->username,
            'email' => $user->email,
            'profile_image' => $user->profile_image,
        ]);

        return back()->with('success', 'Courier profile updated successfully.');
    }
}   
