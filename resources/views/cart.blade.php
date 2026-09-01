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
            <div class="w-full lg:w-2/3 space-y-4">
                <form id="cart-form" action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                </form>

                {{-- BULK SELECT TOOLBAR --}}
                @if (count($items) > 0)
                    <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-3 shadow-sm">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input type="checkbox" id="select-all" class="h-5 w-5 accent-[#FE9494]">
                            <span class="text-sm font-medium text-gray-700">Select All</span>
                        </label>
                        <span class="text-sm text-gray-500">
                            <span id="selected-count">0</span> of {{ count($items) }} selected
                        </span>
                    </div>
                @endif

                {{-- CART ITEMS --}}
                    @forelse ($items as $item)
                        <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm" data-cart-id="{{ $item['cart_id'] }}" data-price="{{ $item['total_price'] }}">

                            {{-- CHECKBOX --}}
                            <div class="flex items-center gap-4">
                                <input
                                    type="checkbox"
                                    name="selected_items[]"
                                    value="{{ $item['cart_id'] }}"
                                    form="cart-form"
                                    class="item-checkbox h-5 w-5 shrink-0 accent-[#FE9494]"
                                >

                                {{-- PRODUCT IMAGE --}}
                                <img
                                    src="{{ $item['products']['product_image'] }}"
                                    alt="{{ $item['products']['product_name'] }}"
                                    class="h-16 w-16 shrink-0 rounded border object-cover sm:h-20 sm:w-20"
                                >

                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium sm:text-base">
                                        {{ $item['products']['product_name'] }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Quantity: {{ $item['quantity'] }}
                                    </p>
                                    <p class="mt-0.5 font-semibold text-sm sm:text-base">
                                        IDR {{ number_format($item['products']['product_price']) }}
                                    </p>
                                </div>
                            </div>

                            {{-- ROW: TOTAL + REMOVE --}}
                            <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-3">
                                <p class="text-sm text-gray-500">
                                    Subtotal: <span class="font-semibold text-gray-900">IDR {{ number_format($item['total_price']) }}</span>
                                </p>

                                <form action="{{ route('cart.destroy', $item['cart_id']) }}" method="POST" onsubmit="return confirm('Remove item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center rounded-md px-2.5 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50">
                                        <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-lg border border-gray-200 bg-white p-10 text-center">
                            <p class="text-gray-500">Your cart is empty.</p>
                            <a href="{{ route('product.index') }}"
                               class="mt-3 inline-block font-medium text-[#FE9494] hover:underline">
                                Continue Shopping →
                            </a>
                        </div>
                    @endforelse
            </div>

            {{-- ================= RIGHT : ORDER SUMMARY ================= --}}
            <div class="w-full lg:w-1/3 rounded-lg border border-gray-200 bg-white p-5 shadow-sm space-y-4">
                <p class="text-xl font-semibold">Order Summary</p>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Selected Items</span>
                    <span id="summary-count">0</span>
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Original Price</span>
                    <span id="summary-original">IDR 0</span>
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Flat Tax</span>
                    <span>IDR {{ number_format($tax ?? 0) }}</span>
                </div>

                <div class="border-t pt-3 flex justify-between font-semibold">
                    <span>Total</span>
                    <span id="summary-total">IDR 0</span>
                </div>

                {{-- CHECKOUT --}}
                <button
                    type="button"
                    id="checkout-btn"
                    onclick="submitSelected()"
                    disabled
                    class="mt-3 flex w-full items-center justify-center rounded-lg bg-[#FE9494] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#e58585] disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Proceed to Checkout
                </button>

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

    {{-- CART SELECTION & ADDRESS CHECK --}}
    <script>
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const selectAll = document.getElementById('select-all');
        const selectedCountEl = document.getElementById('selected-count');
        const summaryCountEl = document.getElementById('summary-count');
        const summaryOriginalEl = document.getElementById('summary-original');
        const summaryTotalEl = document.getElementById('summary-total');
        const checkoutBtn = document.getElementById('checkout-btn');
        const cartForm = document.getElementById('cart-form');
        const tax = {{ $tax ?? 0 }};

        function formatIDR(value) {
            return 'IDR ' + Number(value).toLocaleString('en-US');
        }

        function updateSummary() {
            const checked = Array.from(itemCheckboxes).filter(cb => cb.checked);
            const count = checked.length;
            let original = 0;

            checked.forEach(cb => {
                original += Number(cb.closest('[data-cart-id]').dataset.price);
            });

            selectedCountEl.textContent = count;
            summaryCountEl.textContent = count;
            summaryOriginalEl.textContent = formatIDR(original);
            summaryTotalEl.textContent = formatIDR(original + tax);
            checkoutBtn.disabled = count === 0;
        }

        function submitSelected() {
            const checked = Array.from(itemCheckboxes).filter(cb => cb.checked);

            if (checked.length === 0) {
                return;
            }

            cartForm.submit();
        }

        itemCheckboxes.forEach(cb => cb.addEventListener('change', updateSummary));

        if (selectAll) {
            selectAll.addEventListener('change', function () {
                itemCheckboxes.forEach(cb => {
                    cb.checked = selectAll.checked;
                });
                updateSummary();
            });
        }

        updateSummary();
    </script>
</x-main>
