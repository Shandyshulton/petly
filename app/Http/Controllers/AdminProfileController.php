<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\ProfileImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $admin = User::where('role_role_id', 3)->findOrFail(session('user_id'));

        return view('admin.profile', [
            'admin' => $admin,
        ]);
    }

    public function update(Request $request)
    {
        $admin = User::where('role_role_id', 3)->findOrFail(session('user_id'));

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($admin->user_id, 'user_id')],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10000'],
        ]);

        $admin->username = $validated['username'];
        $admin->email = $validated['email'];
        $admin->phone_number = $validated['phone_number'] ?? null;

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_image')) {
            $admin->profile_image = app(ProfileImageService::class)
                ->store($request->file('profile_image'), $admin->profile_image);
        }

        $admin->save();

        session([
            'username' => $admin->username,
            'email' => $admin->email,
            'profile_image' => $admin->profile_image,
        ]);

        return back()->with('success', 'Admin profile updated successfully.');
    }

    public function theme()
    {
        return view('admin.theme');
    }
}
