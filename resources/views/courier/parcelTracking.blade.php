<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Tracking Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-16 bg-white flex flex-col items-center py-4 shadow-sm">
            <div class="mb-8">
                <img src="/img/logopet.png" alt="Petty Logo" class="w-10 h-7">
            </div>
            <div class="flex flex-col items-center gap-8">
                {{-- <a href="/" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <i class="ri-file-list-line text-gray-400 text-xl"></i>
        </a> --}}
                <a href="/courier/courier-info" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="ri-user-line text-gray-400 text-xl"></i>
                </a>
                <a href="/courier/parcel-tracking"
                    class="p-2 rounded-lg bg-pink-50 hover:bg-pink-100 transition-colors">
                    <i class="ri-truck-line text-pink-400 text-xl"></i>
                </a>
            </div>
            <div class="mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="cursor-pointer p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="ri-logout-box-r-line text-red-500 text-xl"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-4 ml-20 mr-20">
            <!-- Search Bar -->
            <div class="mb-4 flex mt-6">
                <div class="relative flex-1 max-w-md">
                    <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search"
                        class="pl-10 pr-4 py-2 w-full border border-gray-200 rounded-md text-sm">
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Shipping Cards Column -->
                <div class="w-full lg:w-2/5 space-y-4">

                    <!-- resources/views/admin/order.blade.php -->

                    @foreach ($couriers as $delivery)
                        <div class="bg-white rounded-xl p-4 shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <span class="text-gray-700 font-medium">Shipping ID : #
                                        {{ $delivery['delivery_id'] }}</span>
                                </div>
                                <div>
                                    <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-600">
                                        {{ $delivery['transaction']['transaction_status']['transaction_status_name'] }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <div>
                                    <p class="text-xs text-gray-500">Delivery Deadline</p>
                                    <p class="text-xl font-semibold">
                                        {{ \Carbon\Carbon::parse($delivery['delivery_deadline'])->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Delivery Class</p>
                                    <p class="text-md font-medium">
                                        {{ $delivery['delivery_class']['delivery_class_name'] }}</p>
                                </div>
                            </div>
                            <div class="relative flex items-center justify-between py-2 mb-3">
                                <div class="flex items-center">
                                    <p class="text-md font-medium mx-2">Kemanggisan</p>
                                </div>
                                <div class="flex-grow border-t border-gray-300 mx-2"></div>
                                <div class="flex items-center">
                                    <p class="text-md font-medium mx-2">
                                        {{ explode(',', $delivery['delivery_address'])[1] }}</p>
                                </div>
                            </div>
                            <div class="mt-3 mb-2">
                                <p class="text-xs text-gray-500">Full Address</p>
                                <p class="text-sm">{{ $delivery['delivery_address'] }}</p>
                            </div>
                            <div class="mt-3 mb-2">
                                <p class="text-xs text-gray-500">Estimated Delivery</p>
                                <p class="text-sm">{{ $delivery['delivery_class']['delivery_class_desc'] }}</p>
                            </div>
                            <div class="mt-3 mb-2">
                                <p class="text-xs text-gray-500">Transaction Date</p>
                                <p class="text-sm">
                                    {{ \Carbon\Carbon::parse($delivery['transaction']['transaction_date'])->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div class="mt-5">
                                <form action="{{ route('courier.finish') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="courier_id" value="">
                                    <input type="hidden" name="delivery_id" value="{{ $delivery['delivery_id'] }}">
                                    <button type="submit"
                                        class="w-full bg-pink-400 text-white py-2 rounded-lg transition-colors">
                                        Finish Delivery
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Delivery Details -->
                <div class="w-full md:w-4/5 lg:w-3/5 bg-white rounded-xl p-4 md:p-6 shadow-md dark:bg-gray-800 dark:text-white"
                    role="region" aria-label="Shipping Tracker">
                    <div class="grid grid-cols-1 gap-4 md:gap-6">

                        <!-- Map Overview -->
                        <div>
                            <h2 class="text-sm font-semibold text-gray-700 mb-3">MAP OVERVIEW</h2>
                            <div id="map" class="h-[450px] mb-4 rounded-lg"></div>
                        </div>

                        <script>
                            // Initialize the map
                            var map = L.map('map').setView([-6.2088, 106.8456], 13); // Jakarta coordinates

                            // Add the tile layer (map background)
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);

                            // Zoom functions for the buttons
                            function zoomIn() {
                                map.zoomIn();
                            }

                            function zoomOut() {
                                map.zoomOut();
                            }
                        </script>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                        <!-- Vehicle Information -->
                        <div>
                            <h2 class="text-sm font-semibold text-gray-700 mb-3">VEHICLE INFORMATION</h2>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="ri-truck-line text-pink-400"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Mitsubishi Colt L300</p>
                                        <p class="text-sm text-gray-500">Truck</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <div>
                                        <p class="text-xs text-gray-500">PLATE NUMBER</p>
                                        <p class="text-sm">B 117 AL</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Driver Information -->
                        <div>
                            <h2 class="text-sm font-semibold text-gray-700 mb-3">DRIVER</h2>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="ri-user-line text-pink-400"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">James Alexander Scott</p>
                                        <p class="text-sm text-gray-500">Driver</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <div>
                                        <p class="text-xs text-gray-500">PHONE NUMBER</p>
                                        <p class="text-sm">+62 123 123 123</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">EMAIL ADDRESS</p>
                                        <p class="text-sm">salikinsalimin@gmail.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-8 max-w-sm w-full text-center relative">
            <button onclick="closeSuccessModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                <i class="ri-close-line text-xl"></i>
            </button>
            <div class="mb-4 inline-flex items-center justify-center">
                <div class="w-16 h-16 rounded-full bg-pink-100 p-3 relative">
                    <div class="absolute inset-0 rounded-full bg-pink-400 animate-ping opacity-25"></div>
                    <div class="relative w-full h-full bg-pink-400 rounded-full flex items-center justify-center">
                        <i class="ri-check-line text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 mb-1">Delivery Successful</h2>
            <p class="text-gray-500">Great Job!</p>
        </div>
    </div>

</body>
</body>

</html>
