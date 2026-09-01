<script src="https://unpkg.com/lucide@latest"></script>
<x-main>
    <!-- Layout Wrapper -->
    <div class="flex flex-col md:flex-row gap-6 md:gap-12 max-w-7xl w-full mt-8 md:mt-12 mb-16 md:mb-32 mx-auto flex-grow">

        <!-- User Profile Sidebar -->
        <aside class="bg-white shadow-md rounded-xl p-6 w-full md:w-80 md:flex-col md:self-start shrink-0">
            <h2 class="text-xl font-semibold text-center mb-6">User Profile</h2>

            <nav class="flex md:flex-col gap-2 md:gap-4 w-full overflow-x-auto md:overflow-visible">
                <a href="{{ route('profile') }}"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg whitespace-nowrap">
                    <i data-lucide="user"></i> User Info
                </a>
                <a href="{{ route('profile.address') }}"
                    class="flex items-center gap-2 text-red-500 font-semibold px-4 py-2 rounded-lg relative group whitespace-nowrap">
                    <i data-lucide="map-pin"></i> Alamat
                    <span class="hidden md:block absolute right-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-red-500 rounded-full"></span>
                </a>
                <a href="/theme"
                    class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium px-4 py-2 rounded-lg whitespace-nowrap">
                    <i data-lucide="settings"></i> Settings
                </a>
            </nav>

            <div class="border-t w-full mt-6 pt-4 hidden md:block">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="cursor-pointer flex items-center gap-2 text-red-500 font-semibold px-4 py-2">
                        <i data-lucide="log-out"></i> Logout
                    </button>
                </form>
            </div>

        </aside>

        <!-- Address Container -->
        <main class="flex-1 min-w-0 space-y-6">
            <div class="bg-white p-5 sm:p-7 rounded-xl shadow-md">
                <h1 class="text-lg sm:text-xl font-semibold">Alamat Saya</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola alamat pengiriman. Alamat aktif dipakai saat checkout.</p>

                {{-- Daftar alamat --}}
                <div class="mt-6 space-y-3">
                    @forelse ($addresses as $address)
                        <div class="flex items-start gap-3 rounded-lg border p-4 {{ $address->is_active ? 'border-[#FE9494] bg-pink-50' : 'border-gray-200' }}">
                            <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $address->is_active ? 'bg-[#FE9494] text-white' : 'bg-gray-100 text-gray-500' }}">
                                <i data-lucide="map-pin" class="h-4 w-4"></i>
                            </span>
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="font-semibold text-gray-900">
                                        {{ $address->label ?: 'Alamat' }}
                                    </p>
                                    @if ($address->is_active)
                                        <span class="rounded-full bg-[#FE9494] px-2 py-0.5 text-xs font-semibold text-white">Aktif</span>
                                    @endif
                                </div>
                                <p class="mt-1 text-sm text-gray-600 break-words">{{ $address->address }}</p>
                                <p class="text-sm text-gray-500">{{ $address->city }}</p>

                                <div class="mt-3 flex flex-wrap gap-2">
                                    <a href="{{ route('profile.address.edit', $address) }}"
                                        class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:border-[#FE9494] hover:text-[#FE9494]">
                                        Edit
                                    </a>
                                    @if (!$address->is_active)
                                        <form method="POST" action="{{ route('profile.address.set-active', $address) }}">
                                            @csrf
                                            <button type="submit"
                                                class="rounded-lg border border-[#FE9494] px-3 py-1.5 text-xs font-semibold text-[#FE9494] hover:bg-pink-50">
                                                Set Aktif
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('profile.address.destroy', $address) }}"
                                        onsubmit="return confirm('Hapus alamat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-500 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-300 p-8 text-center text-sm text-gray-500">
                            Belum ada alamat. Tambahkan alamat pertamamu di bawah.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Form tambah alamat --}}
            <div class="bg-white p-5 sm:p-7 rounded-xl shadow-md">
                <h2 class="text-base font-semibold">Tambah Alamat Baru</h2>

                <form method="POST" action="{{ route('profile.address.store') }}" class="mt-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
                        <div>
                            <label class="block text-gray-700 mb-2 text-sm font-medium">Label <span class="text-gray-400">(opsional)</span></label>
                            <input type="text" name="label" value="{{ old('label') }}" placeholder="Contoh: Rumah, Kantor"
                                class="w-full p-2 border rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2 text-sm font-medium">City</label>
                            <input id="address-city" type="text" name="city" value="{{ old('city') }}" required
                                class="w-full p-2 border rounded-lg text-sm">
                            @error('city')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="address-text" class="block text-gray-700 mb-2 text-sm font-medium">Nama Jalan, Gedung, No. Rumah</label>
                            <input id="address-text" type="text" name="address" value="{{ old('address') }}" required
                                placeholder="Klik titik pada peta atau ketik alamat lengkap"
                                class="w-full p-2 border rounded-lg text-sm">
                            @error('address')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="address-detail" class="block text-gray-700 mb-2 text-sm font-medium">Detail Lainnya <span class="text-gray-400">(cth: Blok / Unit No., Patokan)</span></label>
                            <input id="address-detail" type="text" name="detail" value="{{ old('detail') }}"
                                placeholder="Cth: Blok A No. 5, dekat minimarket"
                                class="w-full p-2 border rounded-lg text-sm">
                            <p class="mt-1 text-xs text-gray-400">Lengkapi nomor rumah/unit, karena peta hanya mengisi nama jalan &amp; kota secara otomatis.</p>
                            @error('detail')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <input id="address-lat" type="hidden" name="latitude" value="{{ old('latitude') }}">
                    <input id="address-lng" type="hidden" name="longitude" value="{{ old('longitude') }}">

                    <div class="mt-5 space-y-3 rounded-lg border border-gray-200 bg-gray-50 p-4">
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <input id="address-map-search" type="search"
                                class="min-w-0 flex-1 rounded-lg border border-gray-300 bg-white p-2.5 text-sm focus:border-[#FE9494] focus:outline-none focus:ring-2 focus:ring-[#FE9494]/20"
                                placeholder="Cari alamat atau area">
                            <button type="button" id="address-map-search-btn"
                                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <i class="ri-search-line"></i>
                                Search
                            </button>
                        </div>

                        <x-google-map-picker
                            lat="-6.2088"
                            lng="106.8456"
                            addressInputId="address-text"
                            cityInputId="address-city"
                            detailInputId="address-detail"
                            searchInputId="address-map-search"
                            searchBtnId="address-map-search-btn"
                            locBtnId="address-use-current-location"
                            accuracyId="address-location-accuracy"
                            statusId="address-map-status" />

                        <p id="address-map-status" class="text-xs text-gray-500">Klik peta atau geser pin untuk memilih titik lokasi.</p>

                        <button type="button" id="address-use-current-location"
                            class="flex w-full items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-left transition hover:bg-green-100">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-500 text-white">
                                <i class="ri-crosshair-2-line text-xl"></i>
                            </span>
                            <span class="min-w-0">
                                <span class="block text-sm font-semibold text-gray-800">Kirim lokasi Anda saat ini</span>
                                <span id="address-location-accuracy" class="block text-xs text-gray-500">Akurat sampai ±4 meter</span>
                            </span>
                        </button>
                    </div>

                    <div class="mt-6 flex flex-col sm:block text-center">
                        <button type="submit" class="bg-red-400 text-white px-6 py-2 rounded-lg w-full sm:w-auto">
                            Simpan Alamat
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>

</x-main>
