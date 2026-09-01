<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Courier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserManagementController extends Controller
{
    public function show(Request $request)
    {
        $users = User::with('role')
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('user_id', $search)
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%")
                        ->orWhereHas('role', fn ($query) => $query->where('role_name', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('role'), fn ($query) => $query->where('role_role_id', $request->integer('role')))
            ->latest('user_id')
            ->paginate(12)
            ->withQueryString();

            return view('admin.userManagement', [
                'users' => $users,
                'roles' => \App\Models\Role::orderBy('role_name')->get(),
                'filters' => $request->only(['q', 'role']),
            ]);
    }

    public function editCourier($id)
    {
        $courier = User::with('courierDetails')
            ->where('role_role_id', 2)
            ->findOrFail($id);

        return view('admin.editCourier', [
            'courier' => $courier,
        ]);
    }

    public function updateCourier(Request $request, $id)
    {
        $courier = User::with('courierDetails')
            ->where('role_role_id', 2)
            ->findOrFail($id);

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($courier->user_id, 'user_id')],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'vehicle_name' => ['nullable', 'string', 'max:255'],
            'plate_number' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'string', 'in:active,inactive'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $courier->username = $validated['username'];
        $courier->email = $validated['email'];
        $courier->phone_number = $validated['phone_number'] ?? null;

        if (!empty($validated['password'])) {
            $courier->password = Hash::make($validated['password']);
        }

        $courier->save();

        Courier::updateOrCreate(
            ['user_user_id' => $courier->user_id],
            [
                'status' => $validated['status'] ?? 'active',
                'vehicle_name' => $validated['vehicle_name'] ?? null,
                'plate_number' => $validated['plate_number'] ?? null,
            ]
        );

        return redirect()->route('admin.user.index')->with('success', 'Courier updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
    // public function destroy($id)
    // {
    //     $apiToken = session('api_token');
    //     $response = Http::withToken($apiToken)
    //                 ->delete(config('services.petly_api.url') . "/admin/delete-user/{$id}");
    
    //     if ($response->successful()) {
    //         return back()->with('success', 'User deleted successfully.');
    //     } else {
    //         return back()->with('error', 'Failed to delete user.');
    //     }
    // }
}    
