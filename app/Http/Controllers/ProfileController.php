<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)
            ->get('http://petly.test:8080/api/profile');

        $data = $response->json();

        return view('profile', [
            'users'     => $data['user']     ?? [],
            'customers' => $data['customer'] ?? [],
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string',
        ]);

        $fullName = $request->first_name . ' ' . $request->last_name;
        $fullAddress = $request->address . ', ' . $request->city;

        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)->post('http://petly.test:8080/api/profile/update-user', [
            'email' => $request->email,
            'username' => $fullName,
            'phone_number' => $request->phone,
            'address' => $fullAddress,
            'status' => null,
        ]);

        if ($response->successful()) {
            session(['address' => $fullAddress]);
            return back();
        }
    }
}
