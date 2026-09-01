<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class LogoutController extends Controller
{
    public function logout()
    {
        if (session()->has('api_token')) {
            Http::withToken(session('api_token'))
                ->post(config('services.petly_api.url') . '/api/logout');
        }

        // 🔥 Hapus seluruh session web
        session()->invalidate();
        session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
