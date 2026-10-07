<x-main>
    @php
        $items = $products['data'] ?? [];
        $productTypes = collect($items)->pluck('product_type.product_type_name')->filter()->unique()->values();
        $petTypes = collect($items)->pluck('pet_type.pet_type_name')->filter()->unique()->values();
        $filteredItems = collect($items)
            ->when(request('product_type'), fn ($collection, $type) => $collection->where('product_type.product_type_name', $type))
            ->when(request('pet_type'), fn ($collection, $type) => $collection->where('pet_type.pet_type_name', $type))
            ->values();
    @endphp

    <nav class="mt-4 rounded-lg border border-[#FEE7E5] bg-[#FEE7E5]/70 px-3 py-3 text-[#FE9494] sm:mt-6 sm:px-4" aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center gap-2 text-xs font-medium sm:text-sm">
            <li><a href="{{ route('home') }}" class="hover:text-[#FE7070]">Home</a></li>
            <li class="text-[#FE9494]/70">/</li>
            <li>Products</li>
        </ol>
    </nav>

    <section class="py-6 sm:py-8" x-data="{
        modalOpen: false,
        qty: 1,
        current: null,
        openQty(product) {
            this.current = product;
            this.qty = 1;
            this.modalOpen = true;
        }
    }">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-medium text-[#FE9494]">Petly Store</p>
                <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Products</h1>
            </div>

            <form action="{{ route('product.index') }}" method="GET" class="grid w-full gap-3 sm:grid-cols-2 lg:w-auto lg:flex">
                <select name="product_type"
                    class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm outline-none focus:border-[#FE9494] lg:w-44">
                    <option value="">All product types</option>
                    @foreach ($productTypes as $type)
                        <option value="{{ $type }}" @selected(request('product_type') === $type)>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>

                <select name="pet_type"
                    class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm outline-none focus:border-[#FE9494] lg:w-44">
                    <option value="">All pet types</option>
                    @foreach ($petTypes as $type)
                        <option value="{{ $type }}" @selected(request('pet_type') === $type)>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>

                <button type="submit"
                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 sm:col-span-2 lg:col-span-1">
                    Filter
                </button>
            </form>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:grid-cols-4 xl:grid-cols-5">
            @forelse ($filteredItems as $product)
                <article class="overflow-hidden rounded-lg border border-gray-100 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <a href="{{ route('product.show', $product['product_id']) }}" class="flex items-center justify-center bg-white p-2">
                        <img src="{{ $product['product_image'] ?? asset('img/logo-petly.png') }}"
                            alt="{{ $product['product_name'] }}"
                            class="h-36 w-full object-contain sm:h-44 lg:h-48">
                    </a>

                    <div class="p-3">
                        <p class="truncate text-xs uppercase text-gray-400">
                            {{ $product['product_type']['product_type_name'] ?? 'Product' }}
                        </p>
                        <a href="{{ route('product.show', $product['product_id']) }}"
                            class="mt-1 line-clamp-2 min-h-10 text-sm font-semibold text-gray-900 hover:text-[#FE9494]">
                            {{ $product['product_name'] }}
                        </a>

                        <div class="mt-3 flex items-center gap-2">
                            <p class="min-w-0 flex-1 text-sm font-bold text-gray-900 sm:text-base">
                                IDR {{ number_format($product['product_price'], 0, ',') }}
                            </p>

                            @if (session()->has('api_token'))
                                @if ($product['product_stock'] > 0)
                                    <button type="button" @click="openQty(@js($product))"
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-pink-50 text-[#FE9494] hover:bg-pink-100"
                                        aria-label="Add to cart">
                                        <i class="ri-shopping-bag-3-line text-lg"></i>
                                    </button>
                                @else
                                    <span title="Out of stock"
                                        class="flex h-9 w-9 shrink-0 cursor-not-allowed items-center justify-center rounded-full bg-gray-100 text-gray-300"
                                        aria-label="Out of stock">
                                        <i class="ri-shopping-bag-3-line text-lg"></i>
                                    </span>
                                @endif
                            @else
                                <button type="button" onclick="petlyRequireLogin('{{ route('login') }}')"
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-pink-50 text-[#FE9494] hover:bg-pink-100"
                                    aria-label="Add to cart">
                                    <i class="ri-shopping-bag-3-line text-lg"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-lg border border-gray-200 bg-white p-8 text-center text-sm text-gray-500">
                    No products available.
                </div>
            @endforelse
        </div>

        {{-- Quantity picker modal --}}
        <div x-show="modalOpen" x-cloak @keydown.escape.window="modalOpen = false"
            class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true">
            <div class="absolute inset-0 bg-black/40" @click="modalOpen = false"></div>
            <div class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl">
                <template x-if="current">
                    <div>
                        <div class="flex items-start gap-4">
                            <img :src="current.product_image" :alt="current.product_name"
                                class="h-20 w-20 rounded-lg object-cover">
                            <div class="min-w-0 flex-1">
                                <h3 class="line-clamp-2 text-base font-semibold text-gray-900" x-text="current.product_name"></h3>
                                <p class="mt-1 text-sm font-bold text-[#FE9494]"
                                    x-text="'IDR ' + Number(current.product_price).toLocaleString('id-ID')"></p>
                                <p class="mt-1 text-xs text-gray-500">Stock: <span x-text="current.product_stock"></span></p>
                            </div>
                            <button type="button" @click="modalOpen = false"
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-gray-400 hover:bg-gray-100 hover:text-gray-600"
                                aria-label="Close">
                                <i class="ri-close-line text-xl"></i>
                            </button>
                        </div>

                        <form :action="'{{ route('cart.add') }}'" method="POST" class="mt-5">
                            @csrf
                            <input type="hidden" name="product_id" :value="current.product_id">
                            <input type="hidden" name="quantity" :value="qty">

                            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white p-1">
                                <button type="button" @click="qty > 1 ? qty-- : qty"
                                    class="flex h-10 w-10 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100">
                                    <i class="ri-subtract-line"></i>
                                </button>
                                <span x-text="qty" class="min-w-8 text-center text-base font-semibold text-gray-900"></span>
                                <button type="button" @click="qty < current.product_stock ? qty++ : qty"
                                    class="flex h-10 w-10 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100">
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>

                            <button type="submit"
                                class="mt-4 inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-700">
                                <i class="ri-shopping-bag-3-line mr-2 text-lg"></i>
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-main>
