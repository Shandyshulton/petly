<x-main>
    <!-- rating section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12 mt-12 items-stretch">
        <!-- left: description -->
        <div class="bg-white rounded-[20px] shadow-md p-8 h-full flex flex-col justify-between md:h-[100%]">
            <p class="text-[#FF9494] text-xl font-medium pt-5">How It Started</p>

            <h2 class="text-5xl font-semibold text-[#2D2D2D] leading-snug mb-2">
                Our Dream Is <br>
                Global Learning <br>
                Transformation
            </h2>

            <p class="text-gray-600 text-lg leading-relaxed">
                Welcome to PETLY!, your all in one pet shop management system designed to make pet care effortless and
                enjoyable. We offer a seamless platform for purchasing high-quality pet products, booking professional
                grooming services, and accessing expert pet care to keep your furry friends happy and healthy. Whether
                you're a pet owner looking for the best for your
                companion or a business aiming to streamline operations, PETLY! is here to provide convenience,
                reliability, and a pet-friendly experience like no other. With a user-friendly interface and a
                commitment to excellence, PETLY! ensures that every pet receives the best care possible.
            </p>
        </div>

        <!-- right: image + stats (stacked) -->
        <div class="flex flex-col gap-4 h-full">
            <!-- image -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-300">
                <img src="https://images.unsplash.com/photo-1494256997604-768d1f608cac?q=80&w=2129&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    class="w-full h-[250px] md:h-[350px] lg:h-[400px] object-cover">
            </div>


            <!-- stats (2x2 grid) -->
            <div class="bg-white rounded-[20px] shadow-md p-6 flex-grow">
                <div class="grid grid-cols-2 gap-4 h-full">
                    <div class="bg-gray-50 rounded-xl p-6 text-center flex flex-col justify-center">
                        <div class="text-3xl font-bold text-gray-800">4.5</div>
                        <div class="text-sm text-gray-600">years experience</div>
                    </div>
                    <div class="bg-gray-50 rounded-[20px] p-6 text-center flex flex-col justify-center">
                        <div class="text-3xl font-bold text-gray-800">1100+</div>
                        <div class="text-sm text-gray-600">products sold</div>
                    </div>
                    <div class="bg-gray-50 rounded-[20px] p-6 text-center flex flex-col justify-center">
                        <div class="text-3xl font-bold text-gray-800">950+</div>
                        <div class="text-sm text-gray-600">positive reviews</div>
                    </div>
                    <div class="bg-gray-50 rounded-[20px] p-6 text-center flex flex-col justify-center">
                        <div class="text-3xl font-bold text-gray-800">15</div>
                        <div class="text-sm text-gray-600">trusted brands</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- team section -->
    <section class="mt-16 pb-40px">
        <div class="mb-8">
            <p class="text-[#FF9494] text-[24px] font-regular mb-2">Meet The Team</p>
            <h2 class="text-[48px] font-semibold text-gray-800 leading-tight">
                Meet Our Dedicated Team of Pet Care Experts <br> & Tech Innovators
            </h2>
        </div>
    </section>

    <!-- alpine.js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pb-15">
        <!-- team member 1 -->
        <div x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
            class="bg-[#FFE3E1] rounded-[20px] overflow-hidden p-5 flex items-center justify-center relative group transition-all duration-300 hover:shadow-xl">
            <img :src="hovered ? '{{ URL('img/image.png') }}' : '{{ URL('img/imageun.png') }}'" alt="team member"
                class="w-[395px] h-[455px] object-contain transition-transform duration-300 group-hover:scale-105">

            <!-- card (hidden until hover) -->
            <div
                class="absolute bottom-5 bg-white py-2 px-4 rounded-md shadow-md flex items-center justify-between w-[80%] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div>
                    <div class="font-semibold text-gray-800">Team Member</div>
                    <div class="text-xs text-gray-600">Position Title</div>
                </div>

                <a href="#" class="ml-4">
                    <div class="bg-blue-600 p-1 rounded-md flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-white">
                            <path
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- stevie oden patric -->
        <div x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
            class="bg-[#FFE3E1] rounded-[20px] overflow-hidden p-5 flex items-center justify-center relative group transition-all duration-300 hover:shadow-xl">
            <img :src="hovered ? '{{ URL('img/image.png') }}' : '{{ URL('img/imageun.png') }}'" alt="Stevie Oden Patric"
                class="w-[395px] h-[455px] object-contain transition-transform duration-300 group-hover:scale-105">

            <!-- card (hidden until hover) -->
            <div
                class="absolute bottom-5 bg-white py-2 px-4 rounded-md shadow-md flex items-center justify-between w-[80%] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div>
                    <div class="font-semibold text-gray-800">Stevie Oden Patric</div>
                    <div class="text-xs text-gray-600">Chief Executive Officer</div>
                </div>

                <a href="#" class="ml-4">
                    <div class="bg-blue-600 p-1 rounded-md flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-white">
                            <path
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- team member 3 -->
        <div x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
            class="bg-[#FFE3E1] rounded-[20px] overflow-hidden p-5 flex items-center justify-center relative group transition-all duration-300 hover:shadow-xl">
            <img :src="hovered ? '{{ URL('img/image.png') }}' : '{{ URL('img/imageun.png') }}'" alt="team member"
                class="w-[395px] h-[455px] object-contain transition-transform duration-300 group-hover:scale-105">

            <!-- card (hidden until hover) -->
            <div
                class="absolute bottom-5 bg-white py-2 px-4 rounded-md shadow-md flex items-center justify-between w-[80%] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div>
                    <div class="font-semibold text-gray-800">Team Member</div>
                    <div class="text-xs text-gray-600">Position Title</div>
                </div>

                <a href="#" class="ml-4">
                    <div class="bg-blue-600 p-1 rounded-md flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-white">
                            <path
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div> --}}
</x-main>
