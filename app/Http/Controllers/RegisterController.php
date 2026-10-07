<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
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
        // Normalisasi nomor telepon ke format "08...": "8121..." / "+628121..." / "628121..." / "08121..."
        $phone = preg_replace('/\D/', '', $request->phone_number ?? '');
        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '0' . $phone;
        }
        $request->merge(['phone_number' => $phone]);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => ['required', 'string', 'max:15', 'regex:/^08[1-9][0-9]{6,11}$/'],
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Cek email & nomor telepon yang sudah terdaftar di DB (cegah duplikat)
        $emailExists = User::where('email', $request->email)->exists();
        $phoneExists = User::where('phone_number', $request->phone_number)->exists();

        if ($emailExists && $phoneExists) {
            return redirect()->back()
                ->with('failed', 'Email dan nomor telepon sudah terdaftar. Silahkan login.')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        if ($emailExists) {
            return redirect()->back()
                ->with('failed', 'Email sudah terdaftar. Silahkan login.')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        if ($phoneExists) {
            return redirect()->back()
                ->with('failed', 'Nomor telepon sudah terdaftar. Silahkan login.')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            // Make API request to the registration endpoint
            $response = Http::post(config('services.petly_api.url') . '/api/register', [
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
            $errorMessages = collect($errors['errors'] ?? [])->flatten()->implode(', ');

            // If the API reports the email is already taken (race condition fallback)
            if (str_contains($errorMessages, 'email has already been taken') || str_contains($errorMessages, 'The email')) {
                return redirect()->back()
                    ->with('failed', 'Email sudah terdaftar. Silahkan login.')
                    ->withInput($request->except('password', 'password_confirmation'));
            }

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
