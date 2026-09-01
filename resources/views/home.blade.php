<x-main>
    <section class="grid min-h-[calc(100vh-7rem)] items-center gap-8 py-8 sm:py-12 lg:grid-cols-2 lg:gap-12">
        <div class="order-2 lg:order-1">
            <h1 class="max-w-2xl text-4xl font-bold leading-tight text-gray-900 sm:text-5xl lg:text-6xl">
                Care For Your Pet, Love With <span class="text-[#ff9395]">PETLY</span>
            </h1>
            <p class="mt-5 max-w-xl text-base leading-7 text-gray-600 sm:text-lg">
                Your one-stop shop for pet care essentials, made with love for every paw, tail, and whisker.
            </p>
            <a href="{{ route('product.index') }}"
                class="mt-7 inline-flex w-full items-center justify-center rounded-full bg-red-400 px-8 py-3 text-sm font-semibold text-white transition hover:bg-red-500 sm:w-auto">
                Get Started
            </a>
        </div>

        <div class="order-1 flex justify-center lg:order-2 lg:justify-end">
            <img src="{{ URL('img/landingpage.png') }}" alt="Pets"
                class="max-h-72 w-full max-w-md object-contain sm:max-h-96 lg:max-h-[34rem] lg:max-w-xl">
        </div>
    </section>

    <section class="-mx-4 bg-[#ffe7e7] px-4 py-10 text-center sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <p class="text-2xl font-semibold italic text-[#FF9494]">Our Shop</p>
        <h2 class="mt-1 text-2xl font-bold text-gray-900 sm:text-3xl">Shop Our Products</h2>
        <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600 sm:text-base">
            Find everything your pets need, from tasty treats to cozy essentials, all in one place.
        </p>

        <div class="mx-auto mt-7 grid max-w-7xl grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
            @foreach (collect($products['data'] ?? [])->take(4) as $product)
                <article class="overflow-hidden rounded-lg bg-white text-left shadow-sm">
                    <a href="{{ route('product.show', $product['product_id']) }}" class="block">
                        <img src="{{ $product['product_image'] ?? asset('img/logo-petly.png') }}"
                            alt="{{ $product['product_name'] }}"
                            class="h-32 w-full object-cover sm:h-44 lg:h-52">
                    </a>
                    <div class="p-3 sm:p-4">
                        <p class="truncate text-xs uppercase text-gray-400">
                            {{ $product['product_type']['product_type_name'] ?? 'Product' }}
                        </p>
                        <a href="{{ route('product.show', $product['product_id']) }}"
                            class="mt-1 line-clamp-2 min-h-10 text-sm font-semibold text-gray-900 hover:text-[#FE9494] sm:text-base">
                            {{ $product['product_name'] }}
                        </a>
                        <div class="mt-4 flex items-center gap-2">
                            <p class="min-w-0 flex-1 text-sm font-bold text-gray-900 sm:text-base">
                                IDR {{ number_format($product['product_price'], 0, ',') }}
                            </p>
                            @if (session()->has('api_token'))
                                <a href="{{ route('product.show', $product['product_id']) }}"
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#fe9494] text-white hover:bg-[#f57373]"
                                    aria-label="View product">
                                    <i class="ri-shopping-bag-3-line text-lg"></i>
                                </a>
                            @else
                                <button type="button" onclick="petlyRequireLogin('{{ route('login') }}')"
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#fe9494] text-white hover:bg-[#f57373]"
                                    aria-label="Add to cart">
                                    <i class="ri-shopping-bag-3-line text-lg"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <a href="{{ route('product.index') }}"
            class="mt-8 inline-flex w-full items-center justify-center rounded-full bg-red-400 px-8 py-3 text-sm font-semibold text-white transition hover:bg-red-500 sm:w-auto">
            Visit Shop
        </a>
    </section>

    <section class="py-10 sm:py-14">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="flex items-start gap-4 rounded-lg border border-pink-100 bg-white p-4 shadow-sm">
                <i class="ri-scissors-line text-3xl text-[#FF9494]"></i>
                <div>
                    <h3 class="font-semibold text-gray-900">Grooming</h3>
                    <p class="mt-1 text-sm leading-6 text-gray-500">Clean, comfortable grooming support for pets.</p>
                </div>
            </div>
            <div class="flex items-start gap-4 rounded-lg border border-pink-100 bg-white p-4 shadow-sm">
                <i class="ri-heart-pulse-line text-3xl text-[#FF9494]"></i>
                <div>
                    <h3 class="font-semibold text-gray-900">Care</h3>
                    <p class="mt-1 text-sm leading-6 text-gray-500">Simple tools to manage daily pet care needs.</p>
                </div>
            </div>
            <div class="flex items-start gap-4 rounded-lg border border-pink-100 bg-white p-4 shadow-sm">
                <i class="ri-store-2-line text-3xl text-[#FF9494]"></i>
                <div>
                    <h3 class="font-semibold text-gray-900">Store</h3>
                    <p class="mt-1 text-sm leading-6 text-gray-500">Products, stock, and orders in one workflow.</p>
                </div>
            </div>
        </div>

        <div class="mt-12 grid items-center gap-8 lg:grid-cols-2">
            <div class="flex justify-center lg:justify-start">
                <img src="https://as1.ftcdn.net/v2/jpg/00/35/66/46/1000_F_35664648_N33kGk5LKODV6A9Hq5cqDaU9X2VwTPmg.jpg"
                    alt="Cat"
                    class="h-60 w-60 rounded-full object-cover shadow-sm sm:h-80 sm:w-80 lg:h-96 lg:w-96">
            </div>
            <div>
                <p class="text-2xl font-semibold italic text-[#FF9494]">About Us</p>
                <h2 class="mt-2 text-2xl font-bold leading-tight text-gray-900 sm:text-3xl">
                    We Love To Take Care Of Your Pets
                </h2>
                <p class="mt-5 text-sm leading-7 text-gray-600 sm:text-base">
                    Welcome to PETLY, your pet shop management system for quality pet products, grooming, and care.
                </p>
                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    <div class="flex items-center gap-3 text-sm font-medium text-gray-700">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-400">
                            <i class="ri-check-line"></i>
                        </span>
                        Skilled Personal
                    </div>
                    <div class="flex items-center gap-3 text-sm font-medium text-gray-700">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-400">
                            <i class="ri-check-line"></i>
                        </span>
                        Quality Food
                    </div>
                </div>
                <a href="{{ route('about') }}"
                    class="mt-7 inline-flex w-full items-center justify-center rounded-full bg-red-400 px-8 py-3 text-sm font-semibold text-white transition hover:bg-red-500 sm:w-auto">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <section class="pb-12">
        <div class="grid overflow-hidden rounded-lg bg-[#FFE3E1] shadow-sm lg:grid-cols-2">
            <div class="p-6 sm:p-8 lg:p-10">
                <p class="text-2xl font-semibold italic text-[#FF9494]">Meet With Us</p>
                <h2 class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl">Book Your Visit Today</h2>
                <p class="mt-5 text-sm leading-7 text-gray-700 sm:text-base">
                    Looking for vet care or a fresh grooming session? Book your visit and let the team handle the rest.
                </p>
                <a href="{{ route('services') }}"
                    class="mt-7 inline-flex w-full items-center justify-center rounded-full bg-red-400 px-8 py-3 text-sm font-semibold text-white transition hover:bg-red-500 sm:w-auto">
                    Book Now
                </a>
            </div>
            <img src="{{ URL('img/happy-asian.png') }}" alt="Happy woman with dog"
                class="h-64 w-full object-cover sm:h-80 lg:h-full">
        </div>
    </section>
</x-main>
