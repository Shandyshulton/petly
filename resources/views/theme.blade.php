<script src="https://unpkg.com/lucide@latest"></script>
<script src="{{ asset('js/theme.js') }}" defer></script>
<x-main>
    <div class="flex flex-col md:flex-row gap-6 md:gap-12 max-w-7xl w-full mt-8 md:mt-12 mb-16 md:mb-32 mx-auto flex-grow">
        <!-- Sidebar User Profile -->
        <aside
            class="user-profile bg-white dark:bg-gray-800 dark:text-white shadow-md rounded-xl p-6 w-full md:w-80 md:self-start shrink-0">
            <h2 class="text-xl font-semibold text-center mb-6">User Profile</h2>
            <nav class="flex md:flex-col gap-2 md:gap-4 w-full overflow-x-auto md:overflow-visible">
                <a href="/profile"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg whitespace-nowrap">
                    <i data-lucide="user"></i> User Info
                </a>
                <a href="/theme"
                    class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2 rounded-lg relative group whitespace-nowrap">
                    <i data-lucide="settings"></i> Settings
                    <span class="hidden md:block absolute right-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-red-500 rounded-full"></span>
                </a>
            </nav>
            <div class="border-t w-full mt-6 pt-4 hidden md:block">
                <a href="#" class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2">
                    <i data-lucide="log-out"></i> Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
            <!-- Appearance Section -->
            <div
                class="theme-container bg-white dark:bg-gray-800 dark:text-white p-5 sm:p-8 lg:p-10 rounded-xl shadow-md max-w-4xl w-full">
                <h2 class="text-lg font-semibold mb-4 text-center">Appearance</h2>
                <p class="mb-2 text-center">Change Theme</p>
                <div class="flex flex-col sm:flex-row gap-6 items-center justify-center mb-6">
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
                class="pagedone-container bg-white dark:bg-gray-800 dark:text-white p-5 sm:p-8 lg:p-10 rounded-xl shadow-md max-w-4xl w-full mt-6 md:mt-20">
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
        // Theme toggling is handled globally by resources/js/theme.js (window.petlyTheme).
        // The radio inputs (#theme-light / #theme-dark) are wired up there automatically.
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
    </script>

    <style>
        /* Background transition */
        body {
            transition: background-color 0.3s ease-in-out;
        }
    </style>
</x-main>
