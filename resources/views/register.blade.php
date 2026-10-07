<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Create Account</h1>
                    <p class="mt-2 text-sm leading-6 text-gray-600 sm:text-base">
                        Register your account to shop and manage your pet needs.
                    </p>
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <button type="button"
                        class="inline-flex cursor-not-allowed items-center justify-center rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm font-semibold text-gray-500">
                        Google
                    </button>
                    <button type="button"
                        class="inline-flex cursor-not-allowed items-center justify-center rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm font-semibold text-gray-500">
                        Facebook
                    </button>
                </div>

                <div class="my-5 flex items-center gap-3">
                    <span class="h-px flex-1 bg-gray-200"></span>
                    <span class="text-xs font-medium text-gray-500">or continue with email</span>
                    <span class="h-px flex-1 bg-gray-200"></span>
                </div>

                <form method="POST" action="{{ route('register.process') }}">
                    @csrf

                    <label class="block">
                        <span class="mb-1 block text-sm font-semibold text-gray-700">Full Name</span>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus
                            class="w-full rounded-lg border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-[#FF9494] focus:ring-2 focus:ring-[#FF9494]/20">
                    </label>

                    <label class="mt-4 block">
                        <span class="mb-1 block text-sm font-semibold text-gray-700">Email</span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                            class="w-full rounded-lg border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-[#FF9494] focus:ring-2 focus:ring-[#FF9494]/20">
                    </label>

                    <label class="mt-4 block">
                        <span class="mb-1 block text-sm font-semibold text-gray-700">Phone Number</span>
                        <div class="relative">
                            <span
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center rounded-l-lg border border-r-0 border-gray-200 bg-gray-50 px-3 text-sm font-medium text-gray-500">
                                +62
                            </span>
                            <input type="tel" id="phone_number" name="phone_number"
                                value="{{ preg_replace('/^0/', '', old('phone_number')) }}" required
                                placeholder="812xxxxxxxx" inputmode="numeric" maxlength="12"
                                oninput="this.value = this.value.replace(/\D/g, '').replace(/^0+/, '')"
                                class="w-full rounded-lg border border-gray-200 py-3 pl-14 pr-4 text-sm outline-none transition focus:border-[#FF9494] focus:ring-2 focus:ring-[#FF9494]/20">
                        </div>
                        <span class="mt-1 block text-xs text-gray-400">Format: +62 812xxxxxxxx</span>
                        @error('phone_number')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Password</span>
                            <input type="password" id="password" name="password" required autocomplete="new-password"
                                class="w-full rounded-lg border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-[#FF9494] focus:ring-2 focus:ring-[#FF9494]/20">
                        </label>

                        <label class="block">
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Confirm Password</span>
                            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                                class="w-full rounded-lg border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-[#FF9494] focus:ring-2 focus:ring-[#FF9494]/20">
                        </label>
                    </div>

                    <p class="mt-2 text-xs text-gray-500">Password must be at least 8 characters.</p>

                    <button type="submit"
                        class="mt-5 inline-flex w-full items-center justify-center rounded-lg bg-[#FF9494] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#fe7f7f]">
                        Register
                    </button>
                </form>

                <p class="mt-5 text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-semibold text-[#FF9494] hover:text-[#fe7f7f]">
                        Sign in
                    </a>
                </p>
            </section>

            <section class="hidden min-h-[38rem] bg-[#FFE3E1] lg:block">
                <img src="{{ asset('img/registercat1.png') }}" alt="Petly register"
                    class="h-full w-full object-cover">
            </section>
        </div>
    </main>
</body>

</html>
