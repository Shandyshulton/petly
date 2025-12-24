<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class registerController extends Controller
{
    public function showRegisterForm()
    {
        // Define available roles for the dropdown
        $roles = [
            'user' => 'User',
            'owner' => 'Pet Owner',
            'vet' => 'Veterinarian',
        ];
        
        return view('register', compact('roles'));
    }

    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            // Make API request to the registration endpoint
            $response = Http::post('http://petly.test:8080/api/register', [
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'role' => 'customer',
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
            ]);

            // Check if the registration was successful
            if ($response->successful()) {
                // You might want to handle login automatically or redirect with a success message
                return redirect()->route('login')->with('success', 'Registration successful! Please login.');
            }

            // If there was an error in the API response
            $errors = $response->json();
            return redirect()->back()
                ->withErrors($errors['errors'] ?? ['Something went wrong with registration.'])
                ->withInput($request->except('password', 'password_confirmation'));
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['api_error' => 'Could not connect to the registration service.'])
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }
}