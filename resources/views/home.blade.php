<x-main>

    <!-- Header Section -->
    <div class="h-[80vh] flex items-center w-full px-16">
        <div class="w-1/2 pr-10">
            <h1 class="text-6xl font-bold text-gray-800 leading-tight">
                Care For Your<br>
                Pet, Love With <span class="text-[#ff9395]">PETLY</span>
            </h1>
            <p class="text-gray-600 mt-6 text-lg">
                Your one-stop shop for pet care essentials, <br>
                made with love for every paw, tail, and whisker.
            </p>
            <a href="/"
                class="inline-block mt-8 px-10 bg-red-400 hover:bg-red-500 text-white font-medium py-3 px-8 rounded-full transition duration-300">
                Get Started
            </a>
        </div>
        <div class="w-1/2 flex justify-end items-center">
            <img src="{{ URL('img/landingpage.png') }}" alt="Pets" class="w-full h-auto object-co ntain">
        </div>
    </div>

    <!-- Shop Section -->
    <div class="w-full p-10 text-center bg-[#ffe7e7]">
        <h2 class="text-[#FF9494] text-3xl italic font-[Brillotus]">Our Shop</h2>
        <h1 class="text-3xl font-bold text-gray-800">Shop Our Products</h1>
        <p class="text-gray-600 mt-2">Find everything your pets need — from tasty treats to cozy essentials, all in one
            place!</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mt-6 px-10">
            <!-- Product Card -->
            @foreach (collect($products['data'])->take(4) as $product)
                <div class="bg-white p-6 rounded-lg shadow-lg relative">
                    <img src="{{ $product['product_image'] ?? 'https://via.placeholder.com/300' }}"
                        class="w-full h-60 object-cover rounded">
                    <div class="text-left mt-4">
                        <h3 class="text-xl font-semibold"> {{ $product['product_name'] }}</h3>
                        <p class="text-gray-500 uppercase">{{ $product['product_type']['product_type_name'] }}</p>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <p class="text-gray-900 font-bold text-lg">IDR
                            {{ number_format($product['product_price'], 0, ',') }}</p>
                        <button
                            class="w-10 h-10 bg-[#fe9494] flex items-center justify-center rounded-full shadow-md hover:bg-[#f57373] transition">
                            <i class="fi fi-rr-shopping-basket text-white text-lg"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="product"
            class="inline-block mt-8 px-10 bg-red-400 hover:bg-red-500 text-white font-medium py-3 px-8 rounded-full transition duration-300">
            Visit Shop
        </a>
    </div>

    <!-- About Us Section-->
    <div class="w-full p-6 bg-transparent mt-12 mb-12">
        <div class="grid md:grid-cols-3 gap-15 max-w-7xl mx-auto">
            <div
                class="p-5 bg-white border border-pink-200 shadow-md rounded-2xl flex items-center space-x-3 text-left">
                <div class='text-[#FF9494] text-4xl flex-none w-1/4 flex justify-center'><i
                        class="fi fi-rr-scissors"></i> </div>
                <div class='w-3/4'>
                    <h3 class="text-lg font-semibold">Grooming</h3>
                    <p class="text-sm text-gray-500">Lorem ipsum is simply dummy text of the printing and
                        typesetting
                        industry.</p>
                </div>
            </div>

            <div
                class="p-5 bg-white border border-pink-200 shadow-md rounded-2xl flex items-center space-x-3 text-left">
                <div class='text-[#FF9494] text-4xl flex-none w-1/4 flex justify-center'><i class="fi fi-rr-doctor"></i>
                </div>
                <div class='w-3/4'>
                    <h3 class="text-lg font-semibold">Care</h3>
                    <p class="text-sm text-gray-500">Lorem ipsum is simply dummy text of the printing and
                        typesetting
                        industry.</p>
                </div>
            </div>
            <div
                class="p-5 bg-white border border-pink-200 shadow-md rounded-2xl flex items-center space-x-3 text-left">
                <div class='text-[#FF9494] text-4xl flex-none w-1/4 flex justify-center'><i
                        class="fi fi-rr-store-alt"></i> </div>
                <div class='w-3/4'>
                    <h3 class="text-lg font-semibold">Store</h3>
                    <p class="text-sm text-gray-500">Lorem ipsum is simply dummy text of the printing and
                        typesetting
                        industry.</p>
                </div>
            </div>
        </div>

        <div class="flex items-start justify-center mt-20">
            <div class="flex flex-row items-center gap-25 max-w-5xl w-full">
                <!-- Image Section -->
                <div class="relative w-1/2 flex justify-center">
                    <img src="https://as1.ftcdn.net/v2/jpg/00/35/66/46/1000_F_35664648_N33kGk5LKODV6A9Hq5cqDaU9X2VwTPmg.jpg"
                        alt="Cat" class="w-108 h-108 object-cover rounded-full shadow-lg">
                </div>

                <!-- Text Section -->
                <div class="w-1/2">
                    <h4 class="text-[#FF9494] text-3xl italic font-[Brillotus]">About Us</h4>
                    <h2 class="text-3xl font-bold text-gray-900 leading-tight">We Love To Take <br>Care Of Your Pets
                    </h2>
                    <p class="text-gray-600 mt-6 mb-6 text-lg">Welcome to PETLY! – Your ultimate pet shop management
                        system. From high-quality pet products to professional grooming and expert pet care, we make
                        everything easy and convenient. Whether you're a pet owner or a business, PETLY!
                        is here to streamline your experience and ensure every pet gets the best care possible. </p>
                    <div class="flex gap-6 mt-5">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="miter" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Skilled Personal</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Quality Food</span>
                        </div>
                    </div>
                    <a href="aboutus"
                        class="inline-block mt-5 px-10 bg-red-400 hover:bg-red-500 text-white font-medium py-3 px-8 rounded-full transition duration-300">
                        Learn More
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Meet With Us -->
    <div class="flex justify-center items-center py-12 w-full">
        <div class="bg-[#FFE3E1] p-10 rounded-2xl flex items-center shadow-lg">
            <div class="w-1/2 p-8">
                <h3 class="text-[#FF9494] text-3xl italic font-[Brillotus]">Meet With Us</h3>
                <h2 class="text-3xl font-bold mt-4">Book Your Visit Today</h2>
                <p class="text-gray-700 mt-6 text-lg">Looking for expert vet care or a fresh grooming session for your
                    furry friend? Book your visit today and let our friendly team take care of your pet’s health and
                    happiness!</p>
                <a href="services"
                    class="inline-block mt-8 px-10 bg-red-400 hover:bg-red-500 text-white font-medium py-3 px-8 rounded-full transition duration-300">
                    Book Now
                </a>
            </div>
            <div class="w-1/2">
                <img src="{{ URL('img/happy-asian.png') }}" alt="Happy Woman with Dog"
                    class="w-full h-auto rounded-2xl">
            </div>
        </div>
    </div>


</x-main>
