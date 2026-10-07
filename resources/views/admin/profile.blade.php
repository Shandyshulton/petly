<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
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

        <main class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl">
                <div class="mb-6">
                    <p class="text-sm font-medium text-pink-500">Admin</p>
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Edit Profile</h1>
                    <p class="mt-1 text-sm text-gray-500">Update your admin account details.</p>
                </div>

                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-6 flex items-center gap-4">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-pink-50 text-2xl font-bold text-pink-500">
                            @if ($admin->profile_image)
                                <img id="admin-profile-image" src="{{ asset($admin->profile_image) }}" alt="Profile" class="h-full w-full object-cover">
                            @else
                                <span>{{ strtoupper(substr(old('username', $admin->username), 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-lg font-semibold text-gray-900">{{ $admin->username }}</p>
                            <p class="truncate text-sm text-gray-500">{{ $admin->email }}</p>
                        </div>
                    </div>

                    <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
                        <x-profile-image-cropper
                            name="profile_image"
                            :image="$admin->profile_image"
                            fallback="{{ asset('img/logo-petly.png') }}"
                            size="w-16 h-16"
                            inputId="admin_profile_image"
                            previewId="admin-profile-input-preview"
                            hiddenId="admin-profile-hidden"
                            modalId="admin-profile-modal"
                            imageId="admin-profile-crop"
                            confirmId="admin-profile-confirm"
                            cancelId="admin-profile-cancel" />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="sm:col-span-2">
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Username</span>
                            <input type="text" name="username" value="{{ old('username', $admin->username) }}"
                                class="w-full rounded-lg border border-gray-200 bg-white p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20" required>
                            @error('username')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>

                        <label>
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Email</span>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                                class="w-full rounded-lg border border-gray-200 bg-white p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20" required>
                            @error('email')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>

                        <label>
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Phone Number</span>
                            <input type="tel" name="phone_number" value="{{ old('phone_number', $admin->phone_number) }}"
                                class="w-full rounded-lg border border-gray-200 bg-white p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                            @error('phone_number')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>

                        <label>
                            <span class="mb-1 block text-sm font-semibold text-gray-700">New Password</span>
                            <input type="password" name="password"
                                class="w-full rounded-lg border border-gray-200 bg-white p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                            @error('password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>

                        <label>
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Confirm Password</span>
                            <input type="password" name="password_confirmation"
                                class="w-full rounded-lg border border-gray-200 bg-white p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                        </label>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <a href="{{ route('admin.product.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-[#FE9494] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#FE7A7A]">
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
