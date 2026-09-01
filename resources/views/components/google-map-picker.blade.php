{{-- Reusable Google Maps picker.
     Renders a draggable-marker map that writes into:
       - hidden inputs named "latitude" / "longitude" (default ids below)
       - text inputs #{{ $addressInputId }} and #{{ $cityInputId }}
     Also wires the "current location" button and search box inside this block.

     Usage inside a form:
       <x-google-map-picker
           :lat="old('latitude', $address->latitude ?? null)"
           :lng="old('longitude', $address->longitude ?? null)"
           addressInputId="address-text"
           cityInputId="address-city"
           detailInputId="address-detail"
           searchInputId="address-map-search"
           searchBtnId="address-map-search-btn"
           locBtnId="address-use-current-location"
           accuracyId="address-location-accuracy"
           statusId="address-map-status"
       />
--}}

@php
    $apiKey = config('services.google_maps.key');
    $mapId = $mapId ?? 'google-map';
    $latInputId = $latInputId ?? 'address-lat';
    $lngInputId = $lngInputId ?? 'address-lng';
    $defaultLat = $lat ?? -6.2088;
    $defaultLng = $lng ?? 106.8456;
@endphp

@if ($apiKey)
    <div class="relative">
        <div id="{{ $mapId }}" class="h-72 w-full overflow-hidden rounded-lg border border-gray-200"></div>
    </div>

    <button type="button" id="{{ $useBtnId ?? 'google-map-use-address' }}"
        class="mt-3 flex w-full items-center justify-center gap-2 rounded-lg bg-[#FE9494] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#FE7A7A]">
        <i class="ri-check-line"></i>
        Jadikan Alamat
    </button>

    {{-- 1) Define the global callback + queue BEFORE the Google script tag,
         so there is no race condition when Google's async script loads. --}}
    <script>
        window.initPetlyGoogleMap = window.initPetlyGoogleMap || function () {
            (window.__petlyMapInits || []).forEach(function (init) {
                try { init(); } catch (e) { /* per-instance */ }
            });
        };
        window.__petlyMapInits = window.__petlyMapInits || [];
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initPetlyGoogleMap&libraries=places">
    </script>

    {{-- 2) Register this instance's initializer. Runs either immediately when
         Google is already loaded, or later via the global callback. --}}
    <script>
        window.__petlyMapInits.push(function () {
            const mapEl = document.getElementById('{{ $mapId }}');

            if (!mapEl || mapEl.dataset.initialized) {
                return;
            }

            // Google Maps needs a valid div size. If 0x0 (page not laid out yet),
            // retry after window.load.
            const rect = mapEl.getBoundingClientRect();
            if (rect.width === 0 || rect.height === 0) {
                if (!mapEl.dataset.waiting) {
                    mapEl.dataset.waiting = '1';
                    window.addEventListener('load', function () {
                        setTimeout(function () {
                            mapEl.dataset.waiting = '';
                            window.initPetlyGoogleMap();
                        }, 50);
                    });
                }
                return;
            }

            mapEl.dataset.initialized = '1';

            const latInput = document.getElementById('{{ $latInputId }}');
            const lngInput = document.getElementById('{{ $lngInputId }}');
            const addressInput = document.getElementById('{{ $addressInputId }}');
            const cityInput = document.getElementById('{{ $cityInputId }}');
            const statusEl = document.getElementById('{{ $statusId }}');
            const accuracyEl = document.getElementById('{{ $accuracyId }}');

            const initialLat = parseFloat('{{ $defaultLat }}');
            const initialLng = parseFloat('{{ $defaultLng }}');
            const hasInitial = Number.isFinite(initialLat) && Number.isFinite(initialLng) && initialLat !== 0 && initialLng !== 0;

            const center = hasInitial ? { lat: initialLat, lng: initialLng } : { lat: -6.2088, lng: 106.8456 };

            const map = new google.maps.Map(mapEl, {
                center: center,
                zoom: hasInitial ? 16 : 12,
                mapTypeId: 'roadmap',
                fullscreenControl: true,
                streetViewControl: false,
                mapTypeControl: false,
            });

            const marker = new google.maps.Marker({
                position: center,
                map: map,
                draggable: true,
                title: 'Geser untuk mengatur lokasi',
            });

            // Trigger resize saat ukuran window berubah (rotasi HP / keyboard)
            window.addEventListener('resize', function () {
                google.maps.event.trigger(map, 'resize');
            });

            // Isi hidden inputs saat pertama kali (jika ada koordinat tersimpan)
            if (hasInitial) {
                latInput.value = initialLat;
                lngInput.value = initialLng;
            }

            async function reverseGeocode(lat, lng) {
                if (statusEl) statusEl.textContent = 'Mengambil alamat dari titik peta...';

                // 1) Coba Google Geocoding API
                try {
                    const res = await fetch(
                        `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key={{ $apiKey }}&language=id`
                    );
                    const data = await res.json();

                    if (data.status === 'OK' && data.results.length > 0) {
                        const result = data.results[0];
                        const comps = {};
                        result.address_components.forEach(function (c) {
                            if (c.types.includes('route')) comps.route = c.long_name;
                            if (c.types.includes('street_number')) comps.number = c.long_name;
                            if (c.types.includes('sublocality_level_1')) comps.sub = c.long_name;
                            if (c.types.includes('administrative_area_level_2')) comps.city = c.long_name;
                            if (c.types.includes('administrative_area_level_1')) comps.state = c.long_name;
                        });

                        const area = [comps.route, comps.sub].filter(Boolean).join(', ');
                        const city = comps.city || comps.state || '';

                        if (area && addressInput) addressInput.value = area;
                        if (city && cityInput) cityInput.value = city;

                        if (statusEl) statusEl.textContent = 'Titik lokasi sudah dipilih.';
                        return true;
                    }
                    // status bukan OK → lanjut ke fallback
                } catch (e) {
                    // network error → lanjut ke fallback
                }

                // 2) Fallback: Photon (komoot) — gratis, tanpa API key
                try {
                    const photonRes = await fetch(
                        `https://photon.komoot.io/reverse?lat=${lat}&lon=${lng}`
                    );
                    const photonData = await photonRes.json();
                    const props = photonData.features?.[0]?.properties || {};

                    const street = props.street || props.name || '';
                    const district = props.district || '';
                    const city = props.city || props.state || props.country || '';

                    const area = [street, district].filter(Boolean).join(', ');

                    if (area && addressInput) addressInput.value = area;
                    if (city && cityInput) cityInput.value = city;

                    if (area || city) {
                        if (statusEl) statusEl.textContent = 'Titik lokasi sudah dipilih.';
                        return true;
                    }
                } catch (e) {
                    // fallback gagal juga
                }

                if (statusEl) statusEl.textContent = 'Tidak dapat mengambil alamat. Ketik manual atau coba lagi.';
                return false;
            }

            marker.addListener('dragend', function () {
                const pos = marker.getPosition();
                const lat = pos.lat().toFixed(6);
                const lng = pos.lng().toFixed(6);
                latInput.value = lat;
                lngInput.value = lng;
                reverseGeocode(lat, lng);
            });

            map.addListener('click', function (e) {
                const lat = e.latLng.lat().toFixed(6);
                const lng = e.latLng.lng().toFixed(6);
                marker.setPosition({ lat: parseFloat(lat), lng: parseFloat(lng) });
                latInput.value = lat;
                lngInput.value = lng;
                reverseGeocode(lat, lng);
            });

            // Search box (Google Places Autocomplete via input)
            const searchInput = document.getElementById('{{ $searchInputId }}');
            const searchBtn = document.getElementById('{{ $searchBtnId }}');

            if (searchInput && window.google && window.google.maps && window.google.maps.places) {
                const autocomplete = new google.maps.places.Autocomplete(searchInput, {
                    types: ['address'],
                    componentRestrictions: { country: 'id' },
                });

                autocomplete.addListener('place_changed', function () {
                    const place = autocomplete.getPlace();
                    if (!place.geometry) return;

                    const lat = place.geometry.location.lat().toFixed(6);
                    const lng = place.geometry.location.lng().toFixed(6);
                    marker.setPosition({ lat: parseFloat(lat), lng: parseFloat(lng) });
                    map.setCenter({ lat: parseFloat(lat), lng: parseFloat(lng) });
                    map.setZoom(16);
                    latInput.value = lat;
                    lngInput.value = lng;
                    reverseGeocode(lat, lng);
                });
            }

            if (searchBtn && searchInput) {
                searchBtn.addEventListener('click', function () {
                    const query = searchInput.value.trim();
                    if (query) {
                        const geocoder = new google.maps.Geocoder();
                        geocoder.geocode({ address: query }, function (results, status) {
                            if (status === 'OK' && results[0]) {
                                const loc = results[0].geometry.location;
                                const lat = loc.lat().toFixed(6);
                                const lng = loc.lng().toFixed(6);
                                marker.setPosition({ lat: parseFloat(lat), lng: parseFloat(lng) });
                                map.setCenter({ lat: parseFloat(lat), lng: parseFloat(lng) });
                                map.setZoom(16);
                                latInput.value = lat;
                                lngInput.value = lng;
                                reverseGeocode(lat, lng);
                            } else if (statusEl) {
                                statusEl.textContent = 'Lokasi tidak ditemukan.';
                            }
                        });
                    }
                });
            }

            // Current location button
            const locBtn = document.getElementById('{{ $locBtnId }}');
            if (locBtn) {
                locBtn.addEventListener('click', function () {
                    if (!navigator.geolocation) {
                        if (statusEl) statusEl.textContent = 'Browser tidak mendukung deteksi lokasi.';
                        return;
                    }
                    if (statusEl) statusEl.textContent = 'Mencari lokasi perangkat...';

                    navigator.geolocation.watchPosition(function (position) {
                        const lat = position.coords.latitude.toFixed(6);
                        const lng = position.coords.longitude.toFixed(6);

                        if (position.coords.accuracy && accuracyEl) {
                            accuracyEl.textContent =
                                'Akurat sampai ±' + Math.round(position.coords.accuracy) + ' meter';
                        }

                        marker.setPosition({ lat: parseFloat(lat), lng: parseFloat(lng) });
                        map.setCenter({ lat: parseFloat(lat), lng: parseFloat(lng) });
                        map.setZoom(16);
                        latInput.value = lat;
                        lngInput.value = lng;
                        reverseGeocode(lat, lng);

                        if (position.coords.accuracy && position.coords.accuracy <= 50) {
                            navigator.geolocation.clearWatch(this.watchId);
                        }
                    }, function () {
                        if (statusEl) statusEl.textContent = 'Lokasi perangkat tidak dapat diakses.';
                    }, {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 0,
                    });
                });
            }

            // "Jadikan Alamat" button: use current marker position as the address
            const useBtn = document.getElementById('{{ $useBtnId ?? 'google-map-use-address' }}');
            if (useBtn) {
                useBtn.addEventListener('click', async function () {
                    const pos = marker.getPosition();
                    const lat = pos.lat().toFixed(6);
                    const lng = pos.lng().toFixed(6);

                    latInput.value = lat;
                    lngInput.value = lng;

                    useBtn.disabled = true;
                    useBtn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i> Menyimpan lokasi...';

                    const ok = await reverseGeocode(lat, lng);

                    if (ok) {
                        useBtn.innerHTML = '<i class="ri-check-double-line"></i> Alamat dipilih';
                        useBtn.classList.remove('bg-[#FE9494]', 'hover:bg-[#FE7A7A]');
                        useBtn.classList.add('bg-green-500', 'hover:bg-green-600');
                        if (statusEl) statusEl.textContent = 'Lokasi marker dijadikan alamat. Lengkapi nomor rumah lalu simpan.';

                        // Fokus ke field detail agar user melengkapi nomor rumah/unit
                        @if ($detailInputId ?? false)
                            const detailEl = document.getElementById('{{ $detailInputId }}');
                            if (detailEl) {
                                detailEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                setTimeout(function () { detailEl.focus(); }, 400);
                            }
                        @endif
                    } else {
                        useBtn.innerHTML = '<i class="ri-check-line"></i> Jadikan Alamat';
                        useBtn.disabled = false;
                        if (statusEl) statusEl.textContent = 'Tidak dapat mengambil alamat. Ketik manual atau coba lagi.';
                    }
                });
            }
        });

        // Jika Google Maps sudah ter-load sebelum instance ini didaftarkan
        // (misal script async selesai lebih dulu), inisialisasi langsung.
        if (window.google && window.google.maps) {
            window.initPetlyGoogleMap();
        }
    </script>
@else
    <div class="flex h-72 w-full items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-50 text-sm text-gray-500">
        Google Maps belum dikonfigurasi. Isi GOOGLE_MAPS_API_KEY di .env.
    </div>
@endif
