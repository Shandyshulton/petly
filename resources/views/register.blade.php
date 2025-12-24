<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="min-h-screen flex justify-center items-center bg-gray-100">
        <div class="w-3/4 bg-white rounded-2xl shadow-xl flex overflow-hidden">
            <!-- Left: Register Form -->
            <div class="w-3/5 p-6 flex flex-col justify-center ml-12 mr-12">
                <div class="mb-4">
                    <img src="{{ URL('img/logopet.png') }}" alt="Logo" class="h-12">
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Create An Account</h2>
                <p class="text-gray-600 mb-4">Welcome back! Select method to log in:</p>

                <div class="flex gap-3 mb-3">
                    <button class="w-1/2 flex items-center justify-center py-2 border rounded-lg bg-gray-100">
                        <i class="fab fa-google mr-2"></i> Google
                    </button>
                    <button class="w-1/2 flex items-center justify-center py-2 border rounded-lg bg-gray-100">
                        <i class="fab fa-facebook mr-2"></i> Facebook
                    </button>
                </div>

                <div class="relative my-3 text-center">
                    <span class="bg-white px-2 text-gray-600">or continue with email</span>
                </div>

                <!-- Tambahkan Form untuk Mengirim Data ke Backend -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <input type="text"
                        class="form-control @error('username') is-invalid @enderror w-full px-4 py-2 mb-2 rounded-lg border border-gray-300"
                        id="username" name="username" value="{{ old('username') }}" placeholder="Full Name" required
                        autofocus>

                    <input type="email"
                        class="form-control @error('email') is-invalid @enderror w-full px-4 py-2 mb-2 rounded-lg border border-gray-300"
                        id="email" name="email" value="{{ old('email') }}" placeholder="Email" required>

                    <input type="tel"
                        class="w-full px-4 py-2 mb-2 rounded-lg border border-gray-300 form-control @error('phone_number') is-invalid @enderror"
                        id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                        placeholder="Phone Number" required>

                    <input type="password"
                        class="w-full px-4 py-2 mb-2 rounded-lg border border-gray-300 form-control @error('password') is-invalid @enderror"
                        id="password" name="password" placeholder="Password" required>
                    <div class="form-text">Password must be at least 8 characters.</div>

                    <input type="password" class="w-full px-4 py-2 mb-2 rounded-lg border border-gray-300 form-control"
                        id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation"
                        required>

                    <div class="flex items-center text-xs text-gray-600 mb-3">
                        {{-- <input type="checkbox" name="terms" class="mr-2">
                        <span>I agree to the <a href="#" class="text-[#FF9494] font-semibold">Terms and
                                Conditions</a> and the <a href="#" class="text-[#FF9494] font-semibold">Privacy
                                Policy</a>.</span> --}}
                    </div>

                    <button type="submit"
                        class="button w-full bg-[#FF9494] text-white py-2 rounded-lg font-semibold btn btn-primary">Register</button>

                </form>

                <p class="text-center text-gray-600 mt-3">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-[#FF9494]">Sign in</a>
                </p>
            </div>

            <div class="w-2/3 flex justify-center items-center p-1">
                <img class="rounded-xl object-cover w-4/4" src="{{ URL('img/registercat1.png') }}"
                    alt="image description">
            </div>
            {{-- <div class="container py-5">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0">Create an Account</h4>
                                </div>
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                id="username" name="username" value="{{ old('username') }}" required
                                                autofocus>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" value="{{ old('email') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Phone Number</label>
                                            <input type="tel"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" required>
                                            <div class="form-text">Password must be at least 8 characters.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm
                                                Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" required>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Register</button>
                                        </div>

                                        <div class="mt-3 text-center">
                                            Already have an account? <a href="{{ route('login') }}">Login here</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}
        </div>
    </div>
</body>

</html>
