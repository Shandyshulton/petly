<x-main>
    <section class="py-10 relative bg-[#FBFCFF] text-gray-900">
        <h2 class="mb-5 text-2xl font-semibold">Shopping Cart</h2>

        {{-- Alert address --}}
        @if (session('alert'))
            <script>
                if (confirm('{{ session('alert') }}')) {
                    window.location.href = "{{ route('profile') }}";
                }
            </script>
        @endif

        <div class="flex flex-col gap-10 lg:flex-row">

            {{-- ================= LEFT : CART ITEMS ================= --}}
            <div class="w-full lg:w-2/3 space-y-6">

                @forelse ($items as $item)
                    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">

                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                            {{-- RADIO SELECT --}}
                            <form action="{{ route('cart.index') }}" method="GET">
                                <input
                                    type="radio"
                                    name="selected_item"
                                    value="{{ $item['cart_id'] }}"
                                    class="h-5 w-5 accent-[#FE9494]"
                                    onchange="this.form.submit()"
                                    @if (isset($selectedCartId) && $selectedCartId == $item['cart_id']) checked @endif
                                >
                            </form>

                            {{-- PRODUCT IMAGE --}}
                            <img
                                src="{{ $item['products']['product_image'] }}"
                                alt="{{ $item['products']['product_name'] }}"
                                class="h-20 w-20 rounded border object-cover"
                            >

                            {{-- PRODUCT INFO --}}
                            <div class="flex-1">
                                <p class="text-base font-medium">
                                    {{ $item['products']['product_name'] }}
                                </p>

                                <form
                                    action="{{ route('cart.destroy', $item['cart_id']) }}"
                                    method="POST"
                                    class="mt-2"
                                    onsubmit="return confirm('Remove item?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="inline-flex items-center text-sm font-medium text-red-600 hover:underline"
                                    >
                                        <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Remove
                                    </button>
                                </form>
                            </div>

                            {{-- PRICE --}}
                            <div class="text-right">
                                <p class="font-semibold">
                                    IDR {{ number_format($item['products']['product_price']) }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Quantity: {{ $item['quantity'] }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Total: IDR {{ number_format($item['total_price']) }}
                                </p>
                            </div>

                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">
                        Your cart is empty.
                    </p>
                @endforelse
            </div>

            {{-- ================= RIGHT : ORDER SUMMARY ================= --}}
            <div class="w-full lg:w-1/3 rounded-lg border border-gray-200 bg-white p-5 shadow-sm space-y-4">

                <p class="text-xl font-semibold">Order Summary</p>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Original Price</span>
                    <span>IDR {{ number_format($selectedTotal ?? 0) }}</span>
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Flat Tax</span>
                    <span>IDR {{ number_format($tax ?? 0) }}</span>
                </div>

                <div class="border-t pt-3 flex justify-between font-semibold">
                    <span>Total</span>
                    <span>IDR {{ number_format($total ?? 0) }}</span>
                </div>

                {{-- CHECKOUT --}}
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    @csrf
                    @if (isset($selectedCartId) && $selectedCartId)
                        <input type="hidden" name="selected_item" value="{{ $selectedCartId }}">
                    @endif

                    <button
                        type="button"
                        onclick="checkAddressAndSubmit()"
                        @if (!isset($selectedCartId) || !$selectedCartId) disabled @endif
                        class="mt-3 flex w-full items-center justify-center rounded-lg bg-[#FE9494] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#e58585] disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Proceed to Checkout
                    </button>
                </form>

                <div class="text-center text-sm text-gray-500">
                    or
                    <a href="{{ route('product.index') }}"
                       class="font-medium text-[#FE9494] hover:underline">
                        Continue Shopping →
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- ADDRESS CHECK --}}
    <script>
        function checkAddressAndSubmit() {
            @if (!session('address'))
                if (confirm('You need to add an address before checking out. Add now?')) {
                    window.location.href = "{{ route('profile') }}";
                }
            @else
                document.getElementById('checkout-form').submit();
            @endif
        }
    </script>
</x-main>
