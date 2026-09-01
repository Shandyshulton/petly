<script src="https://unpkg.com/lucide@latest"></script>
<x-main>
    <!-- Layout Wrapper -->
    <div class="flex flex-col md:flex-row gap-6 md:gap-12 max-w-7xl w-full mt-8 md:mt-12 mb-16 md:mb-32 mx-auto flex-grow">

        <!-- User Profile Sidebar -->
        <aside class="bg-white shadow-md rounded-xl p-6 w-full md:w-80 md:flex-col md:self-start shrink-0">
            <h2 class="text-xl font-semibold text-center mb-6">User Profile</h2>

            <nav class="flex md:flex-col gap-2 md:gap-4 w-full overflow-x-auto md:overflow-visible">
                <a href="{{ route('profile') }}"
                    class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2 rounded-lg relative group whitespace-nowrap">
                    <i data-lucide="user"></i> User Info
                    <span class="hidden md:block absolute right-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-red-500 rounded-full"></span>
                </a>
                <a href="{{ route('profile.address') }}"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg whitespace-nowrap">
                    <i data-lucide="map-pin"></i> Alamat
                </a>
                <a href="/theme"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg whitespace-nowrap">
                    <i data-lucide="settings"></i> Settings
                </a>
            </nav>

            <div class="border-t w-full mt-6 pt-4 hidden md:block">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="cursor-pointer flex items-center gap-2 text-red-500 font-semibold px-4 py-2">
                        <i data-lucide="log-out"></i> Logout
                    </button>
                </form>
            </div>

        </aside>

        <!-- Profile Container -->
        <main class="flex-1 min-w-0">
            <div class="bg-white p-5 sm:p-7 rounded-xl shadow-md">
                <!-- Profile Header -->
                <div class="flex items-center mb-8 sm:mb-12">
                    <div class="relative shrink-0">
                        <img id="profile-image-preview" src="{{ $profileImage ? asset($profileImage) : URL('img/registercat1.png') }}" alt="Profile"
                            class="w-16 h-16 sm:w-24 sm:h-24 rounded-full object-cover border-4 border-gray-300">
                    </div>
                    @php
                        $user = $users[0] ?? null;
                        $nameParts = preg_split('/\s+/', trim($user['username'] ?? ''), 2);
                        $firstName = $nameParts[0] ?? '';
                        $lastName = $nameParts[1] ?? '';
                    @endphp

                    <div class="ml-3 sm:ml-4 min-w-0">
                        <h1 class="text-lg sm:text-xl font-semibold truncate">
                            {{ $user['username'] ?? '—' }}
                        </h1>
                        <p class="text-gray-500 text-sm sm:text-base truncate">
                            {{ $user['email'] ?? '—' }}
                        </p>
                    </div>
                </div>

                <!-- Profile Form (User Info only) -->
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
                        <x-profile-image-cropper
                            name="profile_image"
                            :image="$profileImage"
                            fallback="{{ URL('img/registercat1.png') }}"
                            size="w-16 h-16"
                            inputId="profile_image_input"
                            previewId="profile-image-input-preview"
                            hiddenId="profile-image-hidden"
                            modalId="profile-image-modal"
                            imageId="profile-image-crop"
                            confirmId="profile-image-confirm"
                            cancelId="profile-image-cancel" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-6 sm:gap-y-8">
                        <div>
                            <label class="block text-gray-700 mb-2">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $firstName) }}" class="w-full p-2 border rounded-lg">
                            @error('first_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $lastName) }}" class="w-full p-2 border rounded-lg">
                            @error('last_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Email</label>
                            <input type="email" value="{{ $user['email'] ?? '' }}" disabled
                                class="w-full p-2 border rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed">
                            <p class="mt-1 text-xs text-gray-400">Email tidak dapat diubah.</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" value="{{ $user['phone_number'] ?? '' }}" disabled
                                class="w-full p-2 border rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed">
                            <p class="mt-1 text-xs text-gray-400">Nomor telepon tidak dapat diubah.</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:block text-center mt-8 sm:mt-10">
                        <button type="submit" class="bg-red-400 text-white px-6 py-2 rounded-lg w-full sm:w-auto">Save</button>
                    </div>
                </form>

                <div class="mt-8 border-t pt-4 md:hidden">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="cursor-pointer w-full flex items-center justify-center gap-2 text-red-500 font-semibold px-4 py-2 rounded-lg border border-red-100 hover:bg-red-50">
                            <i data-lucide="log-out"></i> Logout
                        </button>
                    </form>
                </div>

            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>

</x-main>
