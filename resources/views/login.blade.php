<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="min-h-screen flex justify-center items-center bg-gray-100">
        <div class="w-3/4 bg-white rounded-2xl shadow-xl flex overflow-hidden">

            <!-- LEFT -->
            <div class="w-3/5 p-6 flex flex-col justify-center ml-12 mr-12">

                <div class="mb-4">
                    <img src="{{ asset('img/logopet.png') }}" alt="Logo" class="h-12">
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back!</h2>
                <p class="text-gray-600 mb-4">
                    Log in to your account and start your journey.
                </p>

                {{-- ERROR MESSAGE --}}
                @if ($errors->any())
                    <div class="mb-3 text-sm text-red-600">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- LOGIN FORM --}}
                <form method="POST" action="{{ route('login.process') }}">
                    @csrf

                    <div class="flex gap-3 mb-3">
                        <button type="button"
                            class="w-1/2 flex items-center justify-center py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
                            <i class="fab fa-google mr-2"></i> Google
                        </button>

                        <button type="button"
                            class="w-1/2 flex items-center justify-center py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
                            <i class="fab fa-facebook mr-2"></i> Facebook
                        </button>
                    </div>

                    <div class="relative my-3 text-center">
                        <span class="bg-white px-2 text-gray-600">
                            or continue with email
                        </span>
                    </div>

                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required
                        autocomplete="email"
                        class="w-full px-4 py-2 mb-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#FF9494]">

                    <input type="password" name="password" placeholder="Password" required
                        autocomplete="current-password"
                        class="w-full px-4 py-2 mb-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#FF9494]">

                    <button type="submit"
                        class="w-full bg-[#FF9494] text-white py-2 rounded-lg font-semibold hover:opacity-90 transition">
                        Log In
                    </button>
                </form>

                <p class="text-center text-gray-600 mt-3">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-[#FF9494] font-medium">
                        Create an account
                    </a>
                </p>
            </div>

            <!-- RIGHT -->
            <div class="w-2/3 flex justify-center items-center p-1">
                <img class="rounded-xl object-cover w-full h-full" src="{{ asset('img/registercat1.png') }}"
                    alt="image">
            </div>

        </div>
    </div>
</body>

</html>
