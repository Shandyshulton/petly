<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Pemetaan role_id ke setiap "portal" login.
     * 1 = customer, 2 = courier, 3 = admin.
     */
    private const ROLE_CUSTOMER = 1;
    private const ROLE_COURIER  = 2;
    private const ROLE_ADMIN    = 3;

    /**
     * Konfigurasi tiap portal login: view, nama route, dan role yang diizinkan.
     */
    private const PORTALS = [
        'customer' => [
            'view'       => 'login',
            'form_route' => 'login',
            'role_id'    => self::ROLE_CUSTOMER,
        ],
        'admin' => [
            'view'       => 'auth.admin-login',
            'form_route' => 'admin.login',
            'role_id'    => self::ROLE_ADMIN,
        ],
        'courier' => [
            'view'       => 'auth.courier-login',
            'form_route' => 'courier.login',
            'role_id'    => self::ROLE_COURIER,
        ],
    ];

    /* =========================================================
     | FORM
     |========================================================= */

    public function showLoginForm()
    {
        return $this->renderPortal('customer');
    }

    public function showAdminLoginForm()
    {
        return $this->renderPortal('admin');
    }

    public function showCourierLoginForm()
    {
        return $this->renderPortal('courier');
    }

    /* =========================================================
     | PROSES
     |========================================================= */

    public function login(Request $request)
    {
        return $this->process($request, 'customer');
    }

    public function adminLogin(Request $request)
    {
        return $this->process($request, 'admin');
    }

    public function courierLogin(Request $request)
    {
        return $this->process($request, 'courier');
    }

    /* =========================================================
     | INTERNAL
     |========================================================= */

    /**
     * Tampilkan view portal.
     *
     * Hanya lakukan redirect otomatis jika pengguna SUDAH login DAN role-nya
     * cocok dengan portal yang dibuka. Jika role login saat ini berbeda dari
     * portal (mis. sedang login admin lalu membuka /courier/login), form tetap
     * ditampilkan agar pengguna bisa login ulang dengan akun yang sesuai.
     */
    private function renderPortal(string $portal)
    {
        $config = self::PORTALS[$portal];

        if (session()->has('api_token') && session()->has('role_id')) {
            $currentRole = (int) session('role_id');

            // Role sesuai portal → langsung arahkan ke dashboard-nya.
            if ($currentRole === $config['role_id']) {
                return $this->redirectByRole($currentRole);
            }

            // Role berbeda → tampilkan form, beri tahu sedang login sebagai role lain.
            return view($config['view'])->with(
                'activeRoleNotice',
                'Anda sedang login sebagai ' . $this->roleLabel($currentRole)
                    . '. Login di bawah akan menggantikan sesi tersebut.'
            );
        }

        return view($config['view']);
    }

    /**
     * Label role untuk ditampilkan ke pengguna.
     */
    private function roleLabel(int $roleId): string
    {
        return match ($roleId) {
            self::ROLE_CUSTOMER => 'Customer',
            self::ROLE_COURIER  => 'Courier',
            self::ROLE_ADMIN    => 'Admin',
            default             => 'pengguna',
        };
    }

    /**
     * Proses login untuk portal tertentu. Hanya role yang sesuai portal
     * yang boleh masuk lewat halaman tersebut.
     */
    private function process(Request $request, string $portal)
    {
        $config    = self::PORTALS[$portal];
        $formRoute = $config['form_route'];

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
            $response = Http::post(config('services.petly_api.url') . '/api/login', [
                'email'    => $request->email,
                'password' => $request->password,
            ]);

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

            $roleId = (int) $data['data']['role_role_id'];

            // 🔒 Pastikan role akun sesuai dengan portal login yang dipakai
            if ($roleId !== $config['role_id']) {
                return back()
                    ->withErrors([
                        'email' => 'Akun ini tidak dapat login melalui halaman ini. '
                            . 'Silakan gunakan halaman login yang sesuai.',
                    ])
                    ->withInput();
            }

            // 🔐 Regenerate session (PENTING)
            $request->session()->regenerate();

            // Simpan session
            session([
                'api_token' => $data['token'],
                'user_id'   => $data['data']['user_id'],
                'role_id'   => $roleId,
                'username'  => $data['data']['username'] ?? null,
                'email'     => $data['data']['email'] ?? null,
            ]);

            // Khusus portal customer: hormati redirect ke halaman services
            if ($portal === 'customer') {
                $intended = $request->query('redirect');

                if ($intended === 'services' && $roleId === self::ROLE_CUSTOMER) {
                    return redirect()
                        ->route('services')
                        ->with('success', 'Login successful');
                }
            }

            return $this->redirectByRole($roleId)
                ->with('success', 'Login successful');
        } catch (\Throwable $e) {
            return back()->withErrors([
                'api_error' => 'Server error. Please try again later.',
            ]);
        }
    }

    /**
     * Redirect berdasarkan role.
     */
    private function redirectByRole(int $roleId)
    {
        return match ($roleId) {
            self::ROLE_CUSTOMER => redirect()->route('home'),                 // customer
            self::ROLE_COURIER  => redirect()->route('courier.tracking'),     // courier
            self::ROLE_ADMIN    => redirect()->route('admin.product.index'),  // admin
            default             => redirect()->route('home'),
        };
    }
}
