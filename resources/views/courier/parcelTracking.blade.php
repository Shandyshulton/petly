<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Tracking Dashboard</title>
    <script>
        (function () {
            var t = localStorage.getItem('theme');
            if (t === 'dark' || (!t && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-100">
    <x-courier-navbar />
    <div class="min-h-screen">
        <!-- Main Content -->
        <div class="flex-1 p-4 lg:pb-4">
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
                            <div class="flex justify-between items-center mb-2 gap-2">
                                <div>
                                    <span class="text-gray-700 font-medium">Shipping ID : #
                                        {{ $delivery['delivery_id'] }}</span>
                                </div>
                                <div class="shrink-0">
                                    <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-600">
                                        {{ $delivery['transaction']['transaction_status']['transaction_status_name'] }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-wrap justify-between items-center mb-3 gap-2">
                                <div>
                                    <p class="text-xs text-gray-500">Delivery Deadline</p>
                                    <p class="text-base sm:text-lg font-semibold">
                                        {{ \Carbon\Carbon::parse($delivery['delivery_deadline'], 'UTC')->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Delivery Class</p>
                                    <p class="text-sm font-medium">
                                        {{ $delivery['delivery_class']['delivery_class_name'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between py-1.5 mb-2 gap-2">
                                <div class="flex items-center min-w-0">
                                    <p class="text-sm font-medium mx-1 break-words">{{ explode(',', $delivery['delivery_address'])[0] }}</p>
                                </div>
                                <div class="flex-grow border-t border-gray-300 mx-1 shrink-0"></div>
                                <div class="flex items-center min-w-0">
                                    <p class="text-sm font-medium mx-1 break-words">
                                        {{ explode(',', $delivery['delivery_address'])[1] ?? '' }}</p>
                                </div>
                            </div>
                            <div class="mt-3 mb-2">
                                <p class="text-xs text-gray-500">Full Address</p>
                                <p class="text-sm break-words">{{ $delivery['delivery_address'] }}</p>
                                @php
                                    // Ekstrak koordinat dari "| Pin: lat lng" jika ada
                                    $pinMatch = [];
                                    $hasPin = preg_match('/Pin:\s*(-?\d+(?:\.\d+)?)\s+(-?\d+(?:\.\d+)?)/', $delivery['delivery_address'] ?? '', $pinMatch);
                                @endphp
                                <button type="button"
                                    onclick="openGoogleMaps('{{ $hasPin ? $pinMatch[1] . ',' . $pinMatch[2] : urlencode($delivery['delivery_address']) }}', {{ $hasPin ? 'true' : 'false' }})"
                                    class="mt-2 inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:border-[#FE9494] hover:text-[#FE9494]">
                                    <i class="ri-map-pin-2-line"></i>
                                    Open in Google Maps
                                </button>
                            </div>
                            <div class="mt-2 mb-1">
                                <p class="text-xs text-gray-500">Estimated Delivery</p>
                                <p class="text-sm">{{ $delivery['delivery_class']['delivery_class_desc'] }}</p>
                            </div>
                            <div class="mt-2 mb-1">
                                <p class="text-xs text-gray-500">Transaction Date</p>
                                <p class="text-sm">
                                    {{ \Carbon\Carbon::parse($delivery['transaction']['transaction_date'], 'UTC')->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div class="mt-4">
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
                            <div class="relative">
                                <div id="map" class="h-[450px] rounded-lg"></div>
                                <button type="button" onclick="locateCourier()"
                                    class="absolute right-3 top-3 z-[1000] flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-700 shadow-md hover:bg-gray-50"
                                    aria-label="Lokasi saya" title="Lokasi saya">
                                    <i class="ri-crosshair-2-line text-xl"></i>
                                </button>
                            </div>
                            <p id="map-status" class="mt-2 text-xs text-gray-500">Klik ikon untuk menampilkan posisi Anda.</p>
                        </div>

                        <script>
                            // Initialize the map
                            var map = L.map('map').setView([-6.2088, 106.8456], 13); // Jakarta coordinates

                            // Add the tile layer (map background)
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);

                            // Blue dot layer (Google Maps style "your location")
                            var courierLocationLayer = L.layerGroup().addTo(map);

                            function setCourierLocationDot(lat, lng) {
                                courierLocationLayer.clearLayers();

                                L.circle([lat, lng], {
                                    radius: 30,
                                    color: '#4285F4',
                                    weight: 1,
                                    fillColor: '#4285F4',
                                    fillOpacity: 0.15,
                                }).addTo(courierLocationLayer);

                                L.circleMarker([lat, lng], {
                                    radius: 8,
                                    color: '#ffffff',
                                    weight: 3,
                                    fillColor: '#4285F4',
                                    fillOpacity: 1,
                                }).addTo(courierLocationLayer);
                            }

                            function locateCourier() {
                                var status = document.getElementById('map-status');

                                if (!navigator.geolocation) {
                                    status.textContent = 'Browser tidak mendukung deteksi lokasi.';
                                    return;
                                }

                                status.textContent = 'Mencari lokasi perangkat...';

                                navigator.geolocation.getCurrentPosition(function (position) {
                                    var lat = position.coords.latitude.toFixed(6);
                                    var lng = position.coords.longitude.toFixed(6);

                                    setCourierLocationDot(lat, lng);
                                    map.setView([lat, lng], 16);

                                    status.textContent = position.coords.accuracy
                                        ? 'Posisi Anda aktif (akurat sampai ±' + Math.round(position.coords.accuracy) + ' meter).'
                                        : 'Posisi Anda aktif.';
                                }, function () {
                                    status.textContent = 'Lokasi perangkat tidak dapat diakses.';
                                }, {
                                    enableHighAccuracy: true,
                                    timeout: 10000,
                                    maximumAge: 0
                                });
                            }

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
                                <div class="mt-4 flex flex-wrap justify-between gap-4">
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

    <!-- Google Maps Modal -->
    <div id="googleMapsModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4"
        style="display:none">
        <div class="w-full max-w-3xl rounded-xl bg-white p-4 shadow-xl">
            <div class="mb-3 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-800">Customer Location</h3>
                <button type="button" onclick="closeGoogleMaps()" class="text-gray-400 hover:text-gray-600">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
            <div class="overflow-hidden rounded-lg">
                <iframe id="googleMapsFrame" title="Google Maps" class="h-[60vh] w-full border-0" allowfullscreen
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button type="button" onclick="closeGoogleMaps()"
                    class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    Close
                </button>
                <a id="googleMapsExternalLink" href="#" target="_blank" rel="noopener noreferrer"
                    class="rounded-lg bg-[#FE9494] px-4 py-2 text-sm font-semibold text-white hover:bg-[#FE7A7A]">
                    Open in new tab
                </a>
            </div>
        </div>
    </div>

    <script>
        function openGoogleMaps(query, isCoordinate) {
            const frame = document.getElementById('googleMapsFrame');
            const modal = document.getElementById('googleMapsModal');
            const externalLink = document.getElementById('googleMapsExternalLink');

            // Saat koordinat tersedia, maps langsung memusatkan ke titik itu (z=16),
            // bukan menampilkan daftar hasil pencarian.
            frame.src = 'https://www.google.com/maps?q=' + query + '&z=16&output=embed';
            externalLink.href = 'https://www.google.com/maps/search/?api=1&query=' + query;

            modal.style.display = 'flex';
        }

        function closeGoogleMaps() {
            const frame = document.getElementById('googleMapsFrame');
            const modal = document.getElementById('googleMapsModal');

            modal.style.display = 'none';
            frame.src = '';
        }
    </script>
</body>
</html>
