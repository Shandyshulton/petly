<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminSession
{
    /**
     * Role id untuk admin (sesuai data API: role_role_id = 3).
     */
    private const ADMIN_ROLE_ID = 3;

    /**
     * Lindungi halaman admin berbasis session.
     *
     * Autentikasi di aplikasi ini disimpan di session (api_token, role_id),
     * bukan via guard Laravel, sehingga pengecekan dilakukan terhadap session.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Belum login sama sekali
        if (!$request->session()->has('api_token')) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        }

        // Sudah login tapi bukan admin
        if ((int) $request->session()->get('role_id') !== self::ADMIN_ROLE_ID) {
            abort(403, 'Unauthorized. Halaman ini hanya untuk admin.');
        }

        return $next($request);
    }
}
