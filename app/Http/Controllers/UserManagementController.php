<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;


class UserManagementController extends Controller
{
    public function show()
    {
        $users = User::all();

            return view('admin.userManagement', ['users' => $users]);
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
    //                 ->delete("http://petly.test:8080/admin/delete-user/{$id}");
    
    //     if ($response->successful()) {
    //         return back()->with('success', 'User deleted successfully.');
    //     } else {
    //         return back()->with('error', 'Failed to delete user.');
    //     }
    // }
}    
