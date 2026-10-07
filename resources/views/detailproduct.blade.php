<x-main>
    <nav class="mt-4 rounded-lg border border-[#FEE7E5] bg-[#FEE7E5]/70 px-3 py-3 text-[#FE9494] sm:mt-6 sm:px-4" aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center gap-2 text-xs font-medium sm:text-sm">
            <li><a href="{{ route('home') }}" class="hover:text-[#FE7070]">Home</a></li>
            <li class="text-[#FE9494]/70">/</li>
            <li><a href="{{ route('product.index') }}" class="hover:text-[#FE7070]">Product</a></li>
            <li class="text-[#FE9494]/70">/</li>
            <li class="max-w-[14rem] truncate text-gray-500 sm:max-w-none">{{ $product['product_name'] }}</li>
        </ol>
    </nav>

    <div class="mt-4">
        <a href="{{ route('product.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-[#FE9494] hover:text-[#FE9494]">
            <i class="ri-arrow-left-line"></i>
            Back to Products
        </a>
    </div>

    <section class="py-6 sm:py-10">
        <div class="grid gap-6 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:gap-10">
            <div class="flex items-center justify-center overflow-hidden rounded-lg border border-gray-100 bg-white p-4 shadow-sm">
                <img src="{{ $product['product_image'] ?? asset('img/logo-petly.png') }}"
                    alt="{{ $product['product_name'] }}"
                    class="h-64 w-full object-contain sm:h-80 lg:h-[520px]">
            </div>

            <div class="flex min-w-0 items-center">
                <div class="w-full" x-data="{ quantity: 1, maxStock: {{ $product['product_stock'] }} }">
                    <p class="text-sm font-medium uppercase tracking-wide text-[#FE9494]">
                        {{ $product['product_type']['product_type_name'] ?? 'Product' }}
                    </p>
                    <h1 class="mt-2 text-2xl font-bold leading-tight text-gray-900 sm:text-3xl lg:text-4xl">
                        {{ $product['product_name'] }}
                    </h1>

                    <div class="mt-4 flex items-center gap-2">
                        <i class="ri-star-fill text-xl text-yellow-400"></i>
                        <span class="text-sm font-semibold text-gray-800 sm:text-base">{{ $product['product_rating'] }}/10</span>
                    </div>

                    <p class="mt-5 text-sm leading-7 text-gray-600 sm:text-base">
                        {{ $product['product_desc'] }}
                    </p>

                    <div class="mt-6 grid grid-cols-2 gap-3 sm:max-w-sm">
                        <div class="rounded-lg border border-gray-200 bg-white p-3">
                            <p class="text-xs font-medium text-[#FF9494] sm:text-sm">Weight</p>
                            <p class="mt-1 text-sm font-semibold text-gray-800 sm:text-base">50 gram</p>
                        </div>
                        <div class="rounded-lg border border-gray-200 bg-white p-3">
                            <p class="text-xs font-medium text-[#FF9494] sm:text-sm">Stock</p>
                            <p class="mt-1 text-sm font-semibold {{ $product['product_stock'] <= 0 ? 'text-red-500' : 'text-gray-800' }} sm:text-base">
                                {{ $product['product_stock'] > 0 ? $product['product_stock'] : 'Out of Stock' }}
                            </p>
                        </div>
                    </div>

                    <p class="mt-6 text-2xl font-bold text-gray-900 sm:text-3xl">
                        IDR {{ number_format($product['product_price'], 0, ',') }}
                    </p>

                    @if ($product['product_stock'] <= 0)
                        <div class="mt-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
                            This product is currently out of stock.
                        </div>
                    @endif

                    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center">
                        <div class="flex w-full items-center justify-between rounded-lg border border-gray-200 bg-white p-1 sm:w-36">
                            <button type="button" @click="quantity > 1 ? quantity-- : quantity"
                                class="flex h-10 w-10 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                                {{ $product['product_stock'] <= 0 ? 'disabled' : '' }}>
                                <i class="ri-subtract-line"></i>
                            </button>
                            <span x-text="quantity" class="min-w-8 text-center text-base font-semibold text-gray-900"></span>
                            <button type="button" @click="quantity < maxStock ? quantity++ : quantity"
                                class="flex h-10 w-10 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                                {{ $product['product_stock'] <= 0 ? 'disabled' : '' }}>
                                <i class="ri-add-line"></i>
                            </button>
                        </div>

                        @if (session()->has('api_token'))
                            @if ($product['product_stock'] > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="w-full sm:w-auto">
                                    @csrf
                                    <input type="hidden" name="customer_user_id" value="">
                                    <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                                    <input type="hidden" name="quantity" value="1" x-bind:value="quantity">
                                    <button type="submit"
                                        class="inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-700 sm:w-auto">
                                        <i class="ri-shopping-bag-3-line mr-2 text-lg"></i>
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <button type="button" disabled
                                    class="inline-flex w-full cursor-not-allowed items-center justify-center rounded-lg bg-gray-400 px-5 py-3 text-sm font-semibold text-white sm:w-auto">
                                    Out of Stock
                                </button>
                            @endif
                        @else
                            <button type="button" onclick="petlyRequireLogin('{{ route('login') }}')"
                                class="inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-700 disabled:cursor-not-allowed disabled:opacity-50 sm:w-auto"
                                {{ $product['product_stock'] <= 0 ? 'disabled' : '' }}>
                                <i class="ri-shopping-bag-3-line mr-2 text-lg"></i>
                                {{ $product['product_stock'] <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-main>
