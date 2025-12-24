<x-main>
    <!-- Breadcrumb -->
    <nav class="flex px-5 py-3 text-[#FE9494] border border-[#FEE7E5] rounded-lg bg-[#FEE7E5]/70 mt-9"
        aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="#"
                    class="inline-flex items-center text-sm font-medium text-[#FE9494] hover:text-[#FE7070]">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-[#FE9494]" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="{{ url('/product') }}"
                        class="ms-1 text-sm font-medium text-[#FE9494] hover:text-[#FE7070] md:ms-2">Product</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-[#FE9494]" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="#"
                        class="ms-1 text-sm font-medium text-[#FE9494] hover:text-[#FE7070] md:ms-2">Detail Product</a>
                </div>
            </li>
        </ol>
    </nav>

    <section class="relative py-10">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-0">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mx-auto max-md:px-2">
                <div class="img">
                    <div class="img-box h-full max-lg:mx-auto">
                        <img src="{{ $product['product_image'] }}" alt="Pedigree Dog Dry Food package"
                            class="max-lg:mx-auto lg:ml-auto h-full w-full object-cover max-h-[600px] rounded-lg shadow-sm">
                    </div>
                </div>
                <div
                    class="data w-full lg:pr-8 pr-0 xl:justify-start justify-center flex items-center max-lg:pb-10 xl:my-2 lg:my-5 my-0">
                    <div class="data w-full max-w-xl" x-data="{ quantity: 1 }">
                        <p class="text-lg uppercase font-light leading-8 text-[#000000] mb-4">Pet
                            {{ $product['product_type']['product_type_name'] }}</p>
                        <h2 class="font-sans font-medium text-4xl leading-10 text-gray-900 mb-2">
                            {{ $product['product_name'] }}</h2>

                        <div class="flex items-center mb-6">
                            <div class="flex items-center gap-1 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6 text-yellow-400">
                                    <path fill-rule="evenodd"
                                        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-lg font-medium">{{ $product['product_rating'] }}/10</span>
                            </div>
                        </div>

                        <p class="text-[#505050] text-base font-normal mb-8">
                            {{ $product['product_desc'] }}
                        </p>

                        <div class="grid grid-cols-2 gap-2 mb-8 max-w-xs">
                            <div class="border border-gray-200 rounded-lg p-3">
                                <p class="text-[#FF9494] text-sm mb-1">Weight</p>
                                <p class="text-gray-800 font-medium">50 gram</p>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-3">
                                <p class="text-[#FF9494] text-sm mb-1">Stock</p>
                                <p class="text-gray-800 font-medium {{ $product['product_stock'] <= 0 ? 'text-red-500' : '' }}">
                                    {{ $product['product_stock'] > 0 ? $product['product_stock'] : 'Out of Stock' }}
                                </p>
                            </div>
                        </div>

                        <p class="text-gray-900 text-2xl font-semibold mb-6">IDR
                            {{ number_format($product['product_price'], 0, ',') }}</p>

                        <!-- Stock Alert -->
                        @if ($product['product_stock'] <= 0)
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-red-800 font-medium">This product is currently out of stock</p>
                                </div>
                            </div>
                        @endif

                        <div x-data="{ quantity: 1, maxStock: {{ $product['product_stock'] }} }" class="flex flex-col gap-4">
                            <div class="flex items-center gap-4">
                                <button type="button" @click="quantity > 1 ? quantity-- : quantity"
                                    class="flex items-center justify-center w-10 h-10 rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-100 {{ $product['product_stock'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $product['product_stock'] <= 0 ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <span x-text="quantity" class="text-gray-900 font-medium text-xl"></span>

                                <button type="button" @click="quantity < maxStock ? quantity++ : quantity"
                                    class="flex items-center justify-center w-10 h-10 rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-100 {{ $product['product_stock'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $product['product_stock'] <= 0 ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            @if (session()->has('api_token'))
                                <div class="flex gap-5 mt-6">
                                    @if ($product['product_stock'] > 0)
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="customer_user_id" value="">
                                            <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                                            <input type="hidden" name="quantity" value="1" x-bind:value="quantity">
                                            <button type="submit"
                                                class="bg-gray-800 text-white font-medium py-3 px-4 w-32 border border-gray-800 rounded-lg shadow-sm hover:bg-gray-700 transition-all duration-200 flex items-center justify-center text-sm">
                                                ADD TO CART
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" disabled
                                            class="bg-gray-400 text-white font-medium py-3 px-4 w-32 border border-gray-400 rounded-lg shadow-sm cursor-not-allowed flex items-center justify-center text-sm">
                                            OUT OF STOCK
                                        </button>
                                    @endif
                                </div>

                                @if (session('success'))
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mt-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <p class="text-red-800 font-medium">{{ session('error') }}</p>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="flex gap-5 mt-6">
                                    <button type="button" onclick="alert('You need Login First')"
                                        class="bg-gray-800 text-white font-medium py-3 px-4 w-32 border border-gray-800 rounded-lg shadow-sm hover:bg-gray-700 transition-all duration-200 flex items-center justify-center text-sm {{ $product['product_stock'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $product['product_stock'] <= 0 ? 'disabled' : '' }}>
                                        {{ $product['product_stock'] <= 0 ? 'OUT OF STOCK' : 'ADD TO CART' }}
                                    </button>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
    </section>
</x-main>