<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Courier</title>
    <x-favicon />
    <script>
        (function () {
            var t = localStorage.getItem('theme');
            if (t === 'dark' || (!t && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-gray-100 dark:bg-slate-900">
    <x-toast />

    <div class="min-h-screen">
        <x-admin-navbar />

        <main class="w-full px-4 py-6 sm:px-6 lg:px-8 lg:pl-72">
            <div class="mx-auto max-w-3xl">
                <div class="mb-6">
                    <a href="{{ route('admin.user.index') }}"
                        class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#FE9494]">
                        <i class="ri-arrow-left-line"></i> Back to Users
                    </a>
                    <p class="mt-3 text-sm font-medium text-pink-500">Admin</p>
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Edit Courier</h1>
                    <p class="mt-1 text-sm text-gray-500">Manage courier account and vehicle details.</p>
                </div>

                <form method="POST" action="{{ route('admin.user.update-courier', $courier->user_id) }}"
                    class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-6 flex items-center gap-4">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-pink-50 text-2xl font-bold text-pink-500">
                            {{ strtoupper(substr($courier->username ?? 'C', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-900">{{ $courier->username }}</p>
                            <p class="text-sm text-gray-500">#{{ $courier->user_id }} · Courier</p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="username" class="mb-1 block text-sm font-medium text-gray-700">Username</label>
                            <input id="username" name="username" type="text" value="{{ old('username', $courier->username) }}"
                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                            @error('username')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $courier->email) }}"
                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                            @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="phone_number" class="mb-1 block text-sm font-medium text-gray-700">Phone Number</label>
                            <input id="phone_number" name="phone_number" type="tel" value="{{ old('phone_number', $courier->phone_number) }}"
                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                            @error('phone_number')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="status" class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status"
                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                                <option value="active" @selected(($courier->courierDetails->status ?? 'active') === 'active')>Active</option>
                                <option value="inactive" @selected(($courier->courierDetails->status ?? 'active') === 'inactive')>Inactive</option>
                            </select>
                        </div>

                        <div>
                            <label for="vehicle_name" class="mb-1 block text-sm font-medium text-gray-700">Vehicle</label>
                            <input id="vehicle_name" name="vehicle_name" type="text" value="{{ old('vehicle_name', $courier->courierDetails->vehicle_name ?? '') }}"
                                placeholder="e.g. Mitsubishi Colt L300"
                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                            @error('vehicle_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="plate_number" class="mb-1 block text-sm font-medium text-gray-700">Plate Number</label>
                            <input id="plate_number" name="plate_number" type="text" value="{{ old('plate_number', $courier->courierDetails->plate_number ?? '') }}"
                                placeholder="e.g. B 1127 AL"
                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                            @error('plate_number')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password" class="mb-1 block text-sm font-medium text-gray-700">New Password <span class="text-xs text-gray-400">(optional)</span></label>
                            <input id="password" name="password" type="password" placeholder="Leave blank to keep current"
                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                            @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-1 block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.user.index') }}"
                            class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                            class="rounded-lg bg-[#FE9494] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#FE7A7A]">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
