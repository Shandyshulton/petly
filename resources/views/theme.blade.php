<script src="https://unpkg.com/lucide@latest"></script>
<script src="{{ asset('js/theme.js') }}" defer></script>
<x-main>
    <div class="flex gap-12 max-w-7xl w-full mt-12 mb-32 mx-auto flex-grow">
        <!-- Sidebar User Profile -->
        <aside
            class="user-profile bg-white dark:bg-gray-800 dark:text-white shadow-md rounded-xl p-6 w-80 flex flex-col items-center self-start">
            <h2 class="text-xl font-semibold text-center mb-6">User Profile</h2>
            <nav class="space-y-4 w-full">
                <a href="/profile"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="user"></i> User Info
                </a>
                <a href="/bank"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="landmark"></i> Bank Account
                </a>
                {{-- <a href="/pet" class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg">
                    <i data-lucide="dog"></i> Add Pet
                </a> --}}
                <a href="/theme"
                    class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2 rounded-lg relative group">
                    <i data-lucide="settings"></i> Settings
                    <span class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-red-500 rounded-full"></span>
                </a>
            </nav>
            <div class="border-t w-full mt-6 pt-4">
                <a href="#" class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2">
                    <i data-lucide="log-out"></i> Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Appearance Section -->
            <div
                class="theme-container bg-white dark:bg-gray-800 dark:text-white p-8 lg:p-10 rounded-xl shadow-md max-w-4xl w-full">
                <h2 class="text-lg font-semibold mb-4 text-center">Appearance</h2>
                <p class="mb-2 text-center">Change Theme</p>
                <div class="flex gap-6 items-center justify-center mb-6">
                    <label class="cursor-pointer">
                        <input type="radio" name="theme" id="theme-light" class="hidden"
                            onchange="setTheme('light')">
                        <div
                            class="p-6 rounded-lg border w-24 h-24 flex items-center justify-center dark:border-gray-600">
                            <img src="{{ URL('img/lighttheme.png') }}" alt="Light Mode" class="w-16">
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="theme" id="theme-dark" class="hidden" onchange="setTheme('dark')">
                        <div
                            class="p-6 rounded-lg border w-24 h-24 flex items-center justify-center dark:border-gray-600">
                            <img src="{{ URL('img/darktheme.png') }}" alt="Dark Mode" class="w-16">
                        </div>
                    </label>
                </div>
            </div>

            <!-- Data & Storage Section -->
            <div
                class="pagedone-container bg-white dark:bg-gray-800 dark:text-white p-8 lg:p-10 rounded-xl shadow-md max-w-4xl w-full mt-20">
                <h2 class="text-lg font-semibold mb-4">Data & Storage</h2>
                <button
                    class="w-full p-4 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-200 text-gray-800 rounded-lg flex items-center gap-3">
                    <i data-lucide="trash"></i>
                    <div class="flex flex-col text-left">
                        <p class="font-semibold">Clear cache data</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Quick solution to solve application problems
                        </p>
                    </div>
                </button>
            </div>
        </main>
    </div>

    <script>
        function setTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-theme', 'dark');
                document.body.classList.add('dark-bg');

                document.querySelectorAll('.theme-container, .pagedone-container, .user-profile').forEach(el => {
                    el.classList.add('dark-mode');
                });

                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-theme', 'light');
                document.body.classList.remove('dark-bg');

                document.querySelectorAll('.theme-container, .pagedone-container, .user-profile').forEach(el => {
                    el.classList.remove('dark-mode');
                });

                localStorage.setItem('theme', 'light');
            }
        }

        function loadTheme() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-theme', 'dark');
                document.body.classList.add('dark-bg');

                document.querySelectorAll('.theme-container, .pagedone-container, .user-profile').forEach(el => {
                    el.classList.add('dark-mode');
                });

                document.getElementById('theme-dark').checked = true;
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-theme', 'light');
                document.body.classList.remove('dark-bg');

                document.querySelectorAll('.theme-container, .pagedone-container, .user-profile').forEach(el => {
                    el.classList.remove('dark-mode');
                });

                document.getElementById('theme-light').checked = true;
            }
        }

        document.addEventListener('DOMContentLoaded', loadTheme);
        lucide.createIcons();
    </script>

    <style>
        /* Background transition */
        body {
            transition: background-color 0.3s ease-in-out;
        }

        /* Dark mode */
        body.dark-bg {
            background-color: #1a1a1a;
            color: white;
        }

        /* Containers in dark mode */
        .theme-container.dark-mode,
        .pagedone-container.dark-mode,
        .user-profile.dark-mode {
            background-color: #2d2d2d;
            color: white;
        }

        /* Light mode container */
        .theme-container,
        .pagedone-container,
        .user-profile {
            background-color: white;
            color: black;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }
    </style>
</x-main>
