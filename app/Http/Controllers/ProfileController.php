<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use App\Support\ProfileImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)
            ->get(config('services.petly_api.url') . '/api/profile');

        $data = $response->json();

        $localUser = User::find(session('user_id'));

        return view('profile', [
            'users'     => $data['user']     ?? [],
            'customers' => $data['customer'] ?? [],
            'profileImage' => $localUser->profile_image ?? null,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10000',
        ]);

        $fullName = $request->first_name . ' ' . $request->last_name;

        // Alamat kini dikelola di tabel `addresses` lokal; kirim alamat aktif ke API
        // agar validasi `address` (required untuk customer) tetap terpenuhi.
        $activeAddress = Address::where('user_user_id', session('user_id'))
            ->where('is_active', true)
            ->first();

        $addressPayload = $activeAddress
            ? $activeAddress->address . ', ' . $activeAddress->city
            : '';

        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)->post(config('services.petly_api.url') . '/api/profile/update-user', [
            'email' => $request->email ?? '',
            'username' => $fullName,
            'phone_number' => $request->phone ?? '',
            'address' => $addressPayload,
            'status' => null,
        ]);

        $localUser = User::find(session('user_id'));

        if ($localUser) {
            $localUser->username = $fullName;

            if ($request->hasFile('profile_image')) {
                $localUser->profile_image = app(ProfileImageService::class)
                    ->store($request->file('profile_image'), $localUser->profile_image);
            }

            $localUser->save();

            session([
                'username' => $fullName,
                'profile_image' => $localUser->profile_image,
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function addressIndex()
    {
        $addresses = Address::where('user_user_id', session('user_id'))
            ->orderByDesc('is_active')
            ->orderByDesc('updated_at')
            ->get();

        return view('profile.address', [
            'addresses' => $addresses,
        ]);
    }

    public function addressStore(Request $request)
    {
        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'detail' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $isFirst = !Address::where('user_user_id', session('user_id'))->exists();

        Address::create([
            'user_user_id' => session('user_id'),
            'label' => $validated['label'] ?? null,
            'address' => $validated['address'],
            'city' => $validated['city'],
            'detail' => $validated['detail'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'is_active' => $isFirst,
        ]);

        return back()->with('success', 'Address added successfully.');
    }

    public function addressSetActive(Address $address)
    {
        abort_unless($address->user_user_id === (int) session('user_id'), 403);

        Address::where('user_user_id', session('user_id'))->update(['is_active' => false]);
        $address->update(['is_active' => true]);

        return back()->with('success', 'Active address updated.');
    }

    public function addressEdit(Address $address)
    {
        abort_unless($address->user_user_id === (int) session('user_id'), 403);

        return view('profile.address-edit', [
            'address' => $address,
        ]);
    }

    public function addressUpdate(Request $request, Address $address)
    {
        abort_unless($address->user_user_id === (int) session('user_id'), 403);

        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'detail' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $address->update([
            'label' => $validated['label'] ?? null,
            'address' => $validated['address'],
            'city' => $validated['city'],
            'detail' => $validated['detail'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ]);

        return redirect()->route('profile.address')
            ->with('success', 'Address updated successfully.');
    }

    public function addressDestroy(Address $address)
    {
        abort_unless($address->user_user_id === (int) session('user_id'), 403);

        $address->delete();

        // Kalau alamat aktif dihapus, aktifkan alamat terbaru yang tersisa.
        if (!Address::where('user_user_id', session('user_id'))->where('is_active', true)->exists()) {
            $latest = Address::where('user_user_id', session('user_id'))
                ->orderByDesc('updated_at')
                ->first();

            if ($latest) {
                $latest->update(['is_active' => true]);
            }
        }

        return back()->with('success', 'Address deleted.');
    }
}
