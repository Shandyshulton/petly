<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
</head>

<body class="min-h-screen bg-gray-100 font-sans dark:bg-slate-900">
    <x-toast />

    <main class="flex min-h-screen items-center justify-center px-4 py-6 sm:px-6 lg:px-8">
        <div class="w-full max-w-5xl overflow-hidden rounded-lg bg-white shadow-sm lg:grid lg:grid-cols-2">
            <section class="flex flex-col justify-center px-5 py-6 sm:px-8 lg:px-10">
                <a href="{{ route('home') }}"
                    class="mb-5 inline-flex w-fit items-center rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    <span class="mr-2">&larr;</span>
                    Back to Home
                </a>

                <img src="{{ asset('img/logopet.png') }}" alt="Petly" class="h-11 w-fit">

                <div class="mt-6">
                    <span class="inline-flex w-fit items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                        Admin Portal
                    </span>
                    <h1 class="mt-3 text-2xl font-bold text-gray-900 sm:text-3xl">Admin Login</h1>
                    <p class="mt-2 text-sm leading-6 text-gray-600 sm:text-base">
                        Masuk dengan akun admin untuk mengelola produk, pesanan, dan pengguna.
                    </p>
                </div>

                @isset($activeRoleNotice)
                    <div class="mt-5 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                        {{ $activeRoleNotice }}
                    </div>
                @endisset

                <form method="POST" action="{{ route('admin.login.process') }}" class="mt-6">
                    @csrf

                    <label class="block">
                        <span class="mb-1 block text-sm font-semibold text-gray-700">Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                            class="w-full rounded-lg border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                    </label>

                    <label class="mt-4 block">
                        <span class="mb-1 block text-sm font-semibold text-gray-700">Password</span>
                        <input type="password" name="password" required autocomplete="current-password"
                            class="w-full rounded-lg border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                    </label>

                    <button type="submit"
                        class="mt-5 inline-flex w-full items-center justify-center rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        Log In as Admin
                    </button>
                </form>

                <div class="mt-5 flex flex-col gap-1 text-center text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
                        Login sebagai Customer
                    </a>
                    <a href="{{ route('courier.login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
                        Login sebagai Courier
                    </a>
                </div>
            </section>

            <section class="hidden min-h-[34rem] bg-indigo-100 lg:block">
                <img src="{{ asset('img/registercat1.png') }}" alt="Petly admin login"
                    class="h-full w-full object-cover">
            </section>
        </div>
    </main>
</body>

</html>
