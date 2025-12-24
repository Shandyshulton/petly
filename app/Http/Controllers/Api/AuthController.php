<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use App\Models\Courier;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /* ===================== REGISTER ===================== */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'      => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:6|confirmed',
            'role'          => 'required|in:customer,admin,courier',
            'phone_number'  => 'required|string|max:12',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $role = Role::where('role_name', $request->role)->firstOrFail();

            $user = User::create([
                'username'      => $request->username,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'phone_number'  => $request->phone_number,
                'role_role_id'  => $role->role_id,
            ]);

            match ($request->role) {
                'customer' => Customer::create(['user_user_id' => $user->user_id]),
                'admin'    => Admin::create(['user_user_id' => $user->user_id]),
                'courier'  => Courier::create([
                    'user_user_id' => $user->user_id,
                    'status'       => 'Available',
                ]),
            };

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'User registered successfully',
                'data'    => $user,
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Registration failed',
            ], 500);
        }
    }

    /* ===================== LOGIN ===================== */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        // 🔥 WAJIB: hapus token lama
        $user->tokens()->delete();

        // ✅ buat token baru
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'token'   => $token,
            'data'    => [
                'user_id'        => $user->user_id,
                'role_role_id'   => $user->role_role_id,
                'username'       => $user->username,
                'email'          => $user->email,
            ]
        ], 200);
    }

    /* ===================== LOGOUT ===================== */
    public function logout(Request $request)
    {
        if ($request->user()) {
            // 🔥 hapus SEMUA token user
            $request->user()->tokens()->delete();
        }

        return response()->json([
            'status'  => true,
            'message' => 'Logged out successfully',
        ]);
    }
}
