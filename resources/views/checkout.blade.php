<x-main>

    {{-- ================= NOTIFICATION ================= --}}
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            <strong>✅ Success:</strong> {{ session('success') }}
        </div>
    @endif

    @if (session('failed'))
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
            <strong>❌ Error:</strong> {{ session('failed') }}
        </div>
    @endif

    <section class="py-10 relative bg-[#FBFCFF] text-gray-900">
        <div class="lg:flex lg:items-start gap-16">

            {{-- ================= LEFT ================= --}}
            <div class="flex-1 space-y-8">

                {{-- DELIVERY DETAILS --}}
                <div class="space-y-4">
                    <h2 class="text-2xl font-semibold">Delivery Details</h2>

                    @php
                        $addressParts = explode(',', $userDetail['address'] ?? '');
                        $city = trim(end($addressParts));
                        $fullAddress = trim($addressParts[0] ?? '');
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Your Name</label>
                            <input disabled value="{{ $user['username'] }}"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Your Email</label>
                            <input disabled value="{{ $user['email'] }}"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Phone Number</label>
                            <input disabled value="{{ $user['phone_number'] }}"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">City</label>
                            <input disabled value="{{ $city }}"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Address</label>
                        <input disabled value="{{ $fullAddress }}"
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm">
                    </div>
                </div>

                {{-- DELIVERY METHODS --}}
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold">Delivery Methods</h3>

                    <form method="POST" action="{{ route('checkout.update-shipping') }}">
                        @csrf
                        <div class="rounded-lg border border-gray-200 p-6">
                            <label class="flex items-start gap-4 cursor-pointer">
                                <input type="radio" name="shipping_fee" value="15000"
                                    {{ $shippingFee == 15000 ? 'checked' : '' }}
                                    onchange="this.form.submit()"
                                    class="mt-1 h-4 w-4 accent-[#FE9494]">

                                <div>
                                    <p class="font-medium">15.000 – Regular Delivery</p>
                                    <p class="text-sm text-gray-500">Get it by 2 up to 4 days</p>
                                </div>
                            </label>
                        </div>
                    </form>
                </div>

                {{-- PAYMENT METHODS --}}
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold">Payment Methods</h3>

                    <form method="POST" action="{{ route('checkout.update-payment') }}">
                        @csrf
                        <div class="rounded-lg border border-gray-200 p-6">
                            <label class="flex items-start gap-4 cursor-pointer">
                                <input type="radio" name="payment_method" value="credit_card"
                                    {{ $paymentMethod === 'credit_card' ? 'checked' : '' }}
                                    onchange="this.form.submit()"
                                    class="mt-1 h-4 w-4 accent-[#FE9494]">

                                <div>
                                    <p class="font-medium">Credit Card</p>
                                    <p class="text-sm text-gray-500">Pay with your credit card</p>
                                </div>
                            </label>
                        </div>
                    </form>
                </div>

            </div>

            {{-- ================= RIGHT ================= --}}
            <div class="w-full max-w-md bg-white border border-gray-200 rounded-lg p-6">

                <h3 class="text-xl font-semibold mb-4">Order Summary</h3>

                {{-- PRODUCT --}}
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ $product['product_image'] }}"
                        class="h-24 w-24 rounded border object-cover">
                    <div>
                        <p class="font-medium">{{ $product['product_name'] }}</p>
                        <p class="text-sm text-gray-500">Quantity: {{ $cart['quantity'] }}</p>
                    </div>
                </div>

                {{-- PRICE SUMMARY --}}
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

                {{-- ACTION --}}
                <div class="mt-6 space-y-2">
                    <form method="POST" action="{{ route('checkout.payment') }}">
                        @csrf
                        <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
                        <input type="hidden" name="transaction_id" value="{{ $transactionId }}">

                        <button
                            class="w-full rounded-lg bg-[#FE9494] py-2 font-medium text-white hover:opacity-90">
                            Confirm Order
                        </button>
                    </form>

                    <form method="POST" action="{{ route('checkout.cancel') }}">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transactionId }}">
                        <button
                            class="w-full rounded-lg border border-red-400 py-2 font-medium text-red-500 hover:bg-gray-50">
                            Cancel Order
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

</x-main>
