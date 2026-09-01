<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Theme</title>
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
        <x-courier-navbar />

        <main class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl">
                <div class="mb-6">
                    <p class="text-sm font-medium text-pink-500">Courier</p>
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Theme</h1>
                    <p class="mt-1 text-sm text-gray-500">Choose the appearance used by courier and user pages.</p>
                </div>

                <section class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="theme" id="theme-light" class="peer sr-only">
                            <div class="rounded-lg border border-gray-200 p-4 transition peer-checked:border-[#FE9494] peer-checked:ring-2 peer-checked:ring-[#FE9494]/20">
                                <div class="flex h-32 items-center justify-center rounded-lg bg-[#FBFCFF]">
                                    <img src="{{ URL('img/lighttheme.png') }}" alt="Light Mode" class="h-16 w-auto">
                                </div>
                                <div class="mt-4 flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">Light Mode</p>
                                        <p class="text-sm text-gray-500">Bright default interface</p>
                                    </div>
                                    <i class="ri-sun-line text-2xl text-[#FE9494]"></i>
                                </div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="theme" id="theme-dark" class="peer sr-only">
                            <div class="rounded-lg border border-gray-200 p-4 transition peer-checked:border-[#FE9494] peer-checked:ring-2 peer-checked:ring-[#FE9494]/20">
                                <div class="flex h-32 items-center justify-center rounded-lg bg-[#3a2a35]">
                                    <img src="{{ URL('img/darktheme.png') }}" alt="Dark Mode" class="h-16 w-auto">
                                </div>
                                <div class="mt-4 flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">Dark Mode</p>
                                        <p class="text-sm text-gray-500">Softer mauve dark interface</p>
                                    </div>
                                    <i class="ri-moon-line text-2xl text-[#FE9494]"></i>
                                </div>
                            </div>
                        </label>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>

</html>
