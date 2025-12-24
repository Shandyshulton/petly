<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        // Jika sudah login, langsung redirect sesuai role
        if (session()->has('api_token') && session()->has('role_id')) {
            return $this->redirectByRole(session('role_id'));
        }

        return view('login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Request ke API
            $response = Http::post('http://petly.test:8080/api/login', [
                'email'    => $request->email,
                'password' => $request->password,
            ]);

            // dd(
            //     $response->status(),
            //     $response->json()
            // );

            // Jika API error
            if (!$response->successful()) {
                return back()
                    ->withErrors(['email' => 'Invalid email or password'])
                    ->withInput();
            }

            $data = $response->json();

            // Validasi struktur response API
            if (
                !isset($data['token']) ||
                !isset($data['data']['user_id']) ||
                !isset($data['data']['role_role_id'])
            ) {
                return back()
                    ->withErrors(['email' => 'Invalid login response from server'])
                    ->withInput();
            }

            // 🔐 Regenerate session (PENTING)
            $request->session()->regenerate();

            // Simpan session
            session([
                'api_token' => $data['token'],
                'user_id'   => $data['data']['user_id'],
                'role_id'   => $data['data']['role_role_id'],
            ]);

            // Redirect sesuai role
            return $this->redirectByRole($data['data']['role_role_id'])
                ->with('success', 'Login successful');
        } catch (\Throwable $e) {
            return back()->withErrors([
                'api_error' => 'Server error. Please try again later.',
            ]);
        }
    }

    /**
     * Redirect berdasarkan role
     */
    private function redirectByRole(int $roleId)
    {
        return match ($roleId) {
            1       => redirect()->route('home'),                 // customer
            2       => redirect()->route('courier.tracking'),     // courier
            3       => redirect()->route('admin.product.index'),  // admin
            default => redirect()->route('home'),
        };
    }
}
