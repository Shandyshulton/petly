<!DOCTYPE html>
<html lang="en" class="h-full bg-[#FBFCFF] dark:bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script>
        // Apply saved theme before CSS paints to avoid flash
        (function () {
            var t = localStorage.getItem('theme');
            if (t === 'dark' || (!t && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css">
    @vite('resources/js/app.js')
    <title>Main Page</title>
</head>
<body class="h-full">
    <div class="min-h-full"><x-navbar></x-navbar>
        <x-toast />

        <main>
            <div class="mx-auto max-w-screen-2xl px-4 pt-4 pb-0 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
        <x-footer></x-footer>
    </div>
</body>
</html>
