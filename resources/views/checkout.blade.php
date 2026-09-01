<x-main>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIINfQXa8K4d8JHYQw5N5a1kP8y3HV9+YVM=" crossorigin="">

    <section class="relative bg-[#FBFCFF] py-10 text-gray-900">
        <div class="flex flex-col gap-10 lg:flex-row lg:items-start">
            <div class="flex-1 space-y-8">
                <div class="space-y-4">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-2xl font-semibold">Delivery Details</h2>
                            <p class="text-sm text-gray-500">Data akun sudah terisi. Lengkapi alamat dan kota pengiriman.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Full Name</label>
                            <input disabled value="{{ $user['username'] ?? '' }}"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Email</label>
                            <input disabled value="{{ $user['email'] ?? '' }}"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Phone Number</label>
                            <input disabled value="{{ $user['phone_number'] ?? '' }}"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm">
                        </div>
                    </div>

                    {{-- Alamat pengiriman: memakai alamat tersimpan, bukan maps --}}
                    <div class="space-y-3 rounded-lg border border-gray-200 bg-white p-4">
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#FE9494] text-white">
                                <i class="ri-map-pin-2-line text-lg"></i>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-700">Alamat Pengiriman</p>
                                @if (!empty($addresses) && count($addresses) > 0)
                                    <p class="mt-1 text-sm font-semibold text-gray-900 break-words">
                                        {{ $addresses->firstWhere('is_active', true)?->label ?: ($addresses->first()?->label ?: 'Alamat') }}
                                    </p>
                                    <p class="text-sm text-gray-600 break-words">{{ $address }}</p>
                                    <p class="text-sm text-gray-500">{{ $city }}</p>

                                    @if (count($addresses) > 1)
                                        <div class="mt-3">
                                            <label for="checkout-saved-address" class="text-xs font-medium text-gray-500">Ganti alamat</label>
                                            <select id="checkout-saved-address"
                                                class="mt-1 w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm focus:border-[#FE9494] focus:outline-none focus:ring-2 focus:ring-[#FE9494]/20">
                                                @foreach ($addresses as $saved)
                                                    <option value="{{ $saved->id }}" data-address="{{ $saved->address }}"
                                                        data-city="{{ $saved->city }}" data-lat="{{ $saved->latitude }}"
                                                        data-lng="{{ $saved->longitude }}" @selected($saved->is_active)>
                                                        {{ $saved->label ?: 'Alamat' }} — {{ $saved->address }}, {{ $saved->city }}
                                                        @if ($saved->is_active) (Aktif) @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                @else
                                    <p class="mt-1 text-sm text-gray-500">
                                        Belum ada alamat tersimpan.
                                        <a href="{{ route('profile.address') }}" class="font-semibold text-[#FE9494] hover:underline">
                                            Tambah alamat
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-xl font-semibold">Delivery Methods</h3>

                    <form method="POST" action="{{ route('checkout.update-shipping') }}">
                        @csrf
                        <div class="rounded-lg border border-gray-200 p-6">
                            <label class="flex cursor-pointer items-start gap-4">
                                <input type="radio" name="shipping_fee" value="15000"
                                    {{ $shippingFee == 15000 ? 'checked' : '' }} onchange="this.form.submit()"
                                    class="mt-1 h-4 w-4 accent-[#FE9494]">

                                <div>
                                    <p class="font-medium">15.000 - Regular Delivery</p>
                                    <p class="text-sm text-gray-500">Get it by 2 up to 4 days</p>
                                </div>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="space-y-4">
                    <h3 class="text-xl font-semibold">Payment Methods</h3>

                    <form method="POST" action="{{ route('checkout.update-payment') }}">
                        @csrf
                        <div class="space-y-3">
                            <label class="flex cursor-pointer items-start gap-4">
                                <input type="radio" name="payment_method" value="qris"
                                    {{ $paymentMethod === 'qris' ? 'checked' : '' }} onchange="this.form.submit()"
                                    class="mt-1 h-4 w-4 accent-[#FE9494]">

                                <div class="flex-1 rounded-lg border border-gray-200 p-5">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="font-medium">QRIS</p>
                                            <p class="text-sm text-gray-500">Scan QR untuk menyelesaikan pembayaran.</p>
                                        </div>
                                        <i class="ri-qr-code-line text-2xl text-[#FE9494]"></i>
                                    </div>
                                </div>
                            </label>

                            <label class="flex cursor-pointer items-start gap-4">
                                <input type="radio" name="payment_method" value="va_bank"
                                    {{ $paymentMethod === 'va_bank' ? 'checked' : '' }} onchange="this.form.submit()"
                                    class="mt-1 h-4 w-4 accent-[#FE9494]">

                                <div class="flex-1 rounded-lg border border-gray-200 p-5">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="font-medium">VA Bank</p>
                                            <p class="text-sm text-gray-500">Bayar melalui virtual account bank.</p>
                                        </div>
                                        <i class="ri-bank-card-line text-2xl text-[#FE9494]"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </form>
                </div>
            </div>

            <div class="w-full rounded-lg border border-gray-200 bg-white p-6 lg:max-w-md">
                <h3 class="mb-4 text-xl font-semibold">Order Summary</h3>

                <div class="mb-6 max-h-72 space-y-4 overflow-y-auto">
                    @forelse ($products as $index => $product)
                        <div class="flex items-center gap-4">
                            <img src="{{ $product['product_image'] }}"
                                class="h-20 w-20 shrink-0 rounded border object-cover">
                            <div class="min-w-0">
                                <p class="truncate font-medium">{{ $product['product_name'] }}</p>
                                <p class="text-sm text-gray-500">Quantity: {{ $carts[$index]['quantity'] ?? '-' }}</p>
                                <p class="text-sm font-semibold">IDR {{ number_format($carts[$index]['total_price'] ?? 0) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No products.</p>
                    @endforelse
                </div>

                <div class="divide-y divide-gray-200 text-sm">
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span>IDR {{ number_format($subtotal) }}</span>
                    </div>

                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Shipping Fee</span>
                        <span>IDR {{ number_format($shippingFee) }}</span>
                    </div>

                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Flat Tax</span>
                        <span>IDR {{ number_format($taxAmount) }}</span>
                    </div>

                    <div class="flex justify-between py-3 font-semibold">
                        <span>Total</span>
                        <span>IDR {{ number_format($total) }}</span>
                    </div>
                </div>

                <div class="mt-5 rounded-lg border border-gray-200 bg-gray-50 p-4">
                    @if ($paymentMethod === 'va_bank')
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="font-semibold">Virtual Account</p>
                                    <p class="text-xs text-gray-500">Gunakan salah satu nomor VA berikut.</p>
                                </div>
                                <i class="ri-bank-card-line text-2xl text-[#FE9494]"></i>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center justify-between rounded-lg bg-white px-3 py-2">
                                    <span class="text-gray-600">BCA</span>
                                    <span class="font-semibold">8808 1234 5678</span>
                                </div>
                                <div class="flex items-center justify-between rounded-lg bg-white px-3 py-2">
                                    <span class="text-gray-600">Mandiri</span>
                                    <span class="font-semibold">8877 1234 5678</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="font-semibold">QRIS</p>
                                    <p class="text-xs text-gray-500">Scan kode ini dari aplikasi pembayaran.</p>
                                </div>
                                <i class="ri-qr-code-line text-2xl text-[#FE9494]"></i>
                            </div>
                            <div class="mx-auto grid h-36 w-36 grid-cols-6 gap-1 rounded-lg border border-gray-200 bg-white p-2">
                                @foreach ([1,1,1,0,1,1,1,0,0,1,0,1,1,0,1,1,1,0,1,0,1,0,0,1,0,1,1,1,0,1,1,0,0,1,1,0] as $cell)
                                    <span class="{{ $cell ? 'bg-gray-900' : 'bg-white' }} rounded-sm"></span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-6 space-y-2">
                    <form id="confirm-order-form" method="POST" action="{{ route('checkout.payment') }}">
                        @csrf
                        <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
                        <input id="confirm-address" type="hidden" name="address" value="{{ old('address', $address) }}">
                        <input id="confirm-city" type="hidden" name="city" value="{{ old('city', $city) }}">
                        <input id="confirm-location-lat" type="hidden" name="location_lat" value="{{ old('location_lat') }}">
                        <input id="confirm-location-lng" type="hidden" name="location_lng" value="{{ old('location_lng') }}">
                        @foreach ($transactionIds as $transactionId)
                            <input type="hidden" name="transaction_ids[]" value="{{ $transactionId }}">
                        @endforeach

                        <button class="w-full rounded-lg bg-[#FE9494] py-2 font-medium text-white hover:opacity-90">
                            Confirm Order
                        </button>
                    </form>

                    <form method="POST" action="{{ route('checkout.cancel') }}">
                        @csrf
                        @foreach ($transactionIds as $transactionId)
                            <input type="hidden" name="transaction_ids[]" value="{{ $transactionId }}">
                        @endforeach
                        <button
                            class="w-full rounded-lg border border-red-400 py-2 font-medium text-red-500 hover:bg-gray-50">
                            Cancel Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        const addressInput = document.getElementById('confirm-address');
        const cityInput = document.getElementById('confirm-city');

        function syncConfirmFields() {
            // Alamat aktif sudah terisi di hidden fields dari server.
        }

        // Dropdown alamat tersimpan: isi hidden fields alamat yang dikirim saat confirm.
        const savedAddressSelect = document.getElementById('checkout-saved-address');

        if (savedAddressSelect) {
            savedAddressSelect.addEventListener('change', function () {
                const option = this.selectedOptions[0];

                if (!option || !option.value) {
                    return;
                }

                document.getElementById('confirm-address').value = option.dataset.address || '';
                document.getElementById('confirm-city').value = option.dataset.city || '';

                if (option.dataset.lat && option.dataset.lng) {
                    document.getElementById('confirm-location-lat').value = option.dataset.lat;
                    document.getElementById('confirm-location-lng').value = option.dataset.lng;
                }
            });
        }
    </script>
</x-main>
