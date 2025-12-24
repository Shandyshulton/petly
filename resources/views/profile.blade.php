<script src="https://unpkg.com/lucide@latest"></script>
<x-main>

    <!-- Layout Wrapper -->
    <div class="flex gap-12 max-w-7xl w-full mt-12 mb-32 mx-auto flex-grow">

        <!-- User Profile Sidebar (Same Style as Profile Container) -->
        <aside class="bg-white shadow-md rounded-xl p-6 w-80 flex flex-col items-center self-start">
            <h2 class="text-xl font-semibold text-center mb-6">User Profile</h2>

            <nav class="space-y-4 w-full">
                <a href="/profile"
                    class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2 rounded-lg relative group">
                    <i data-lucide="user"></i> User Info
                    <span class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-red-500 rounded-full"></span>
                </a>
                <a href="/bank"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="landmark"></i> Bank Account
                </a>
                {{-- <a href="/pet"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="dog"></i> Add Pet
                </a> --}}
                <a href="/theme"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="settings"></i> Settings
                </a>
            </nav>

            <div class="border-t w-full mt-6 pt-4">
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
        <main class="flex-1">
            <div class="bg-white p-7 rounded-xl shadow-md">
                <!-- Profile Header -->
                <div class="flex items-center mb-12">
                    <div class="relative">
                        <img src="{{ URL('img/registercat1.png') }}" alt="Profile"
                            class="w-24 h-24 rounded-full object-cover border-4 border-gray-300">
                        <button class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-md">

                        </button>
                    </div>
                    @php
                        // If you know there's exactly one user
                        $user = $users[0] ?? null;
                        $customer = $customers[0] ?? null;
                    @endphp

                    <div class="ml-4">
                        <h1 class="text-xl font-semibold">
                            {{ $user['username'] ?? '—' }}
                        </h1>
                        <p class="text-gray-500">
                            {{ $customer['address'] ?? '—' }}
                        </p>
                    </div>
                </div>

                <!-- Profile Form -->
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="grid grid-cols-2 gap-x-10 gap-y-8">
                        <div>
                            <label class="block text-gray-700 mb-2">First Name</label>
                            <input type="text" name="first_name" class="w-full p-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Last Name</label>
                            <input type="text" name="last_name" class="w-full p-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" class="w-full p-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" class="w-full p-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Address</label>
                            <input type="text" name="address" class="w-full p-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">City</label>
                            <input type="text" name="city" class="w-full p-2 border rounded-lg">
                        </div>
                    </div>
                    <div class="text-center mt-10">
                        <button type="submit" class="bg-red-400 text-white px-6 py-2 rounded-lg">Save</button>
                    </div>
                </form>

            </div>
        </main>
    </div>

    <script>
        lucide.createIcons(); // Load Lucide Icons
    </script>

</x-main>
