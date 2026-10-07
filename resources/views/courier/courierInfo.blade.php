<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Dashboard</title>
    <x-favicon />
    <script>
        (function () {
            var t = localStorage.getItem('theme');
            if (t === 'dark' || (!t && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    <x-courier-navbar />
    <div class="min-h-screen bg-gray-100 lg:pl-72">
        <!-- Main Content -->
        <div class="flex-1 p-4 mx-auto max-w-7xl mt-6 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Profile Card -->



                <div class="bg-white rounded-lg p-8 shadow-sm" x-data="{ editing: {{ $errors->any() ? 'true' : 'false' }} }">
                    <div class="flex flex-col items-center mb-3">
                        <form id="courier-photo-form" method="POST" action="{{ route('courier.photo.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="relative w-20 h-20 mb-1.5">
                                <div class="w-full h-full rounded-full bg-pink-100 p-0.5">
                                    <img id="courier-profile-image" src="{{ $courier->profile_image ? asset($courier->profile_image) : '/img/courier1.png' }}" alt="Profile" class="w-full h-full rounded-full object-cover">
                                </div>
                                <label for="courier-header-photo-input"
                                    class="absolute bottom-0 right-0 cursor-pointer flex h-7 w-7 items-center justify-center rounded-full bg-[#FE9494] text-white shadow-md hover:bg-[#FE7A7A] transition-colors"
                                    title="Upload photo">
                                    <i class="ri-camera-line text-sm"></i>
                                </label>
                            </div>

                            <x-profile-image-cropper
                                name="profile_image"
                                :image="$courier->profile_image"
                                fallback="/img/courier1.png"
                                size="w-20 h-20"
                                compact
                                onConfirm="submitCourierPhoto"
                                inputId="courier-header-photo-input"
                                previewId="courier-profile-image"
                                hiddenId="courier-header-photo-hidden"
                                modalId="courier-header-photo-modal"
                                imageId="courier-header-photo-crop"
                                confirmId="courier-header-photo-confirm"
                                cancelId="courier-header-photo-cancel" />

                            <script>
                                window.submitCourierPhoto = function () {
                                    document.getElementById('courier-photo-form').submit();
                                };
                            </script>
                        </form>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $courier->username ?? 'Courier' }}</h2>
                        <p class="text-sm text-gray-500">{{ ucfirst($courier->courierDetails->status ?? 'active') }} Courier</p>
                    </div>

                    {{-- Readonly view (default after save) --}}
                    <div x-show="!editing" x-transition>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                                <i class="ri-user-line text-gray-400"></i>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-400">Username</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $courier->username ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                                <i class="ri-mail-line text-gray-400"></i>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-400">Email</p>
                                    <p class="text-sm font-medium text-gray-800 break-all">{{ $courier->email ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                                <i class="ri-phone-line text-gray-400"></i>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-400">Phone Number</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $courier->phone_number ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                                <i class="ri-truck-line text-gray-400"></i>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-400">Vehicle</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $courier->courierDetails->vehicle_name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                                <i class="ri-roadster-line text-gray-400"></i>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-400">Plate Number</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $courier->courierDetails->plate_number ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="button" @click="editing = true"
                                class="w-full bg-pink-400 text-white py-2 rounded-lg hover:bg-pink-500 transition-colors">
                                Edit Profile
                            </button>
                        </div>
                    </div>

                    {{-- Edit form (hidden after save) --}}
                    <form x-show="editing" x-transition method="POST" action="{{ route('courier.profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4 rounded-lg border border-gray-100 bg-gray-50 p-3">
                            <x-profile-image-cropper
                                name="profile_image"
                                :image="$courier->profile_image"
                                fallback="/img/courier1.png"
                                size="w-16 h-16"
                                inputId="courier_profile_image"
                                previewId="courier-profile-input-preview"
                                hiddenId="courier-profile-hidden"
                                modalId="courier-profile-modal"
                                imageId="courier-profile-crop"
                                confirmId="courier-profile-confirm"
                                cancelId="courier-profile-cancel" />
                        </div>

                        <div>
                            <label class="block text-md font-medium text-gray-700 mb-1">Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                    <i class="ri-user-line text-gray-400 text-sm"></i>
                                </div>
                                <input type="text" name="username" value="{{ old('username', $courier->username ?? '') }}"
                                    class="block w-full pl-7 pr-2 py-1 border border-gray-200 rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 text-md">
                            </div>
                            @error('username')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-4">
                            <div class="mt-4">
                                <label class="block text-md font-medium text-gray-700 mb-1">Your Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                        <i class="ri-mail-line text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email', $courier->email ?? '') }}"
                                        class="block w-full pl-7 pr-2 py-1 border border-gray-200 rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 text-md">
                                </div>
                                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-md font-medium text-gray-700 mb-1">Phone Number</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                        <i class="ri-phone-line text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="tel" name="phone_number" value="{{ old('phone_number', $courier->phone_number ?? '') }}"
                                        class="block w-full pl-7 pr-2 py-1 border border-gray-200 rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 text-md">
                                </div>
                                @error('phone_number')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-md font-medium text-gray-700 mb-1">Vehicle</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                        <i class="ri-truck-line text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="text" name="vehicle_name" value="{{ old('vehicle_name', $courier->courierDetails->vehicle_name ?? '') }}"
                                        class="block w-full pl-7 pr-2 py-1 border border-gray-200 rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 text-md">
                                </div>
                                @error('vehicle_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-md font-medium text-gray-700 mb-1">Plate Number</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                        <i class="ri-roadster-line text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="text" name="plate_number" value="{{ old('plate_number', $courier->courierDetails->plate_number ?? '') }}"
                                        class="block w-full pl-7 pr-2 py-1 border border-gray-200 rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 text-md">
                                </div>
                                @error('plate_number')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-md font-medium text-gray-700 mb-1">New Password <span class="text-gray-400 text-xs">(optional)</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                    <i class="ri-lock-line text-gray-400 text-sm"></i>
                                </div>
                                <input type="password" name="password" placeholder="Leave blank to keep current"
                                    class="block w-full pl-7 pr-2 py-1 border border-gray-200 rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 text-md">
                            </div>
                            @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mt-3 flex gap-2">
                            <button type="button" @click="editing = false"
                                class="flex-1 border border-gray-200 text-gray-600 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 bg-pink-400 text-white py-2 rounded-lg hover:bg-pink-500 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Weather and Stats Cards -->
                <div class="space-y-4">
                    <!-- Weather Card -->
                    <div class="bg-white rounded-lg p-4 shadow-sm relative overflow-hidden">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center">
                                <i class="ri-time-line text-red-400 mr-2 text-sm"></i>
                                <h2 id="live-time" class="text-4xl font-light text-gray-700">--:--:--</h2>
                            </div>
                            <div class="absolute right-4 top-4">
                                <i class="ri-calendar-event-line text-pink-200 text-3xl"></i>
                            </div>
                        </div>

                        <div class="mt-2 text-right">
                            <p class="text-gray-500 text-xs">Today:</p>
                            <p id="live-date" class="text-gray-400 text-xs">Loading...</p>
                        </div>

                        <div class="grid grid-cols-4 gap-2 mt-3">
                            <div class="text-center">
                                <p class="text-gray-500 text-[10px] mb-0.5">TIME ZONE</p>
                                <p class="font-medium text-xs">GMT+7</p>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-500 text-[10px] mb-0.5">SUNRISE</p>
                                <p class="font-medium text-xs">05:45</p>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-500 text-[10px] mb-0.5">SUNSET</p>
                                <p class="font-medium text-xs">18:10</p>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-500 text-[10px] mb-0.5">COUNTRY</p>
                                <p class="font-medium text-xs">IDN</p>
                            </div>
                        </div>
                    </div>

                    <script>
                        function updateClock() {
                            const now = new Date();
                            const timeString = now.toLocaleTimeString('en-GB');
                            const dateString = now.toLocaleDateString('en-GB', {
                                weekday: 'long',
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });

                            document.getElementById('live-time').textContent = timeString;
                            document.getElementById('live-date').textContent = dateString;
                        }

                        setInterval(updateClock, 1000);
                        updateClock();
                    </script>

                    <!-- Total Delivery Card -->
                    <div class="bg-white rounded-lg p-4 shadow-sm relative">
                        <div class="flex justify-between">
                            <div>
                                <h2 class="text-2xl font-normal text-gray-800">{{ count($couriers) }}</h2>
                                <p class="text-gray-500 text-sm mt-0.5">Total Delivery</p>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Card -->
                    <div class="bg-white rounded-lg p-4 shadow-sm relative">

                        <h2 class="text-2xl font-normal text-gray-800">{{ $courier->courierDetails->vehicle_name ?? '-' }}</h2>
                        <p class="text-gray-500 text-sm mt-0.5">Vehicle Information</p>
                    </div>

                    <!-- Plate Number Card -->
                    <div class="bg-white rounded-lg p-4 shadow-sm relative">
                        <h2 class="text-2xl font-normal text-gray-800">{{ $courier->courierDetails->plate_number ?? '-' }}</h2>
                        <p class="text-gray-500 text-sm mt-0.5">Plate Number</p>
                    </div>
                </div>
            </div>

            <!-- Delivery History -->
            <div class="mt-4 bg-white rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Delivery History</h2>
                    {{-- <div class="flex items-center gap-2">
                        <div class="relative">
                            <i class="ri-search-line absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input 
                                class="pl-7 pr-3 py-1 w-60 bg-gray-50 border border-gray-200 rounded-md text-xs h-7" 
                                placeholder="Search..." 
                            >
                        </div>
                        <div class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded-md text-xs text-gray-600 h-7">
                            <i class="ri-calendar-line text-xs"></i>
                            <span>25 Dec 2025</span>
                            <i class="ri-arrow-right-s-line text-xs"></i>
                        </div>
                    </div> --}}
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        @if (!empty($couriers))
                            <thead>
                                <tr class="text-left text-[#373737] border-t border-b">
                                    <th class="py-3 pl-2 font-medium text-sm">ID</th>
                                    <th class="py-3 pl-2 font-medium text-sm">Customer Name</th>
                                    <th class="py-3 pl-1 font-medium text-sm">Product Type</th>
                                    <th class="py-3 pl-2 font-medium text-sm">Date</th>
                                    <th class="py-3 pl-2 font-medium text-sm">Status</th>
                                    <th class="py-3 pl-2 font-medium text-sm">Delivery Class</th>
                                    <th class="py-3 pl-2 font-medium text-sm">Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($couriers as $delivery)
                                    <tr class="border-b border-gray-100">
                                        <td class="py-3 text-gray-800 px-2">{{ $delivery['delivery_id'] }}</td>
                                        <td class="py-3 text-gray-800 px-2">
                                            {{ $delivery['transaction']['user']['username'] ?? '-' }}</td>
                                        <td class="py-3 text-gray-800 px-2">
                                            {{ ucwords($delivery['transaction']['transaction_details']['product']['product_type']['product_type_name'] ?? '-') }}
                                        </td>
                                        <td class="py-3 text-gray-500 px-2">
                                            {{ \Carbon\Carbon::parse($delivery['delivery_deadline'], 'UTC')->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                        </td>
                                        <td class="py-1 px-1 uppercase">
                                            <span class="px-1 py-1 bg-green-100 text-green-600 rounded text-[13px]">
                                                {{ $delivery['transaction']['transaction_status']['transaction_status_name'] }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-gray-800 px-2 ">
                                            {{ $delivery['delivery_class']['delivery_class_name'] ?? '-' }}</td>
                                        <td class="py-3 text-gray-800 px-2">
                                            {{ explode(',', $delivery['delivery_address'])[1] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <p class="text-center text-gray-500">No Data Available</p>
                        @endif

                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Photo upload logic is handled by the reusable cropper component.
    </script>
</body>

</html>
