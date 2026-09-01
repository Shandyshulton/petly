<nav class="sticky top-0 z-40 bg-[#FBFCFF] shadow-sm dark:bg-slate-900" x-data="{ isOpen: false, userOpen: false, profileOpen: false }">
    <div class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-8">
        <div class="relative flex min-h-20 items-center justify-between gap-4">
            {{-- Mobile: profile icon left, logo center --}}
            <div class="flex w-20 shrink-0 items-center md:hidden">
                @if (session()->has('api_token'))
                    <div class="relative">
                        <button type="button" @click="isOpen = false; profileOpen = !profileOpen"
                            class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full border border-gray-200 bg-white text-gray-600 hover:border-[#FE9494] hover:text-[#FE9494]"
                            aria-label="Profile">
                            @if (session('profile_image'))
                                <img src="{{ asset(session('profile_image')) }}" alt="Profile" class="h-full w-full object-cover">
                            @else
                                <i class="ri-user-line text-xl"></i>
                            @endif
                        </button>

                        <div x-show="profileOpen" @click.outside="profileOpen = false" x-transition
                            class="absolute left-0 top-11 w-44 overflow-hidden rounded-lg bg-white py-1 shadow-lg ring-1 ring-black/5 dark:bg-slate-800 dark:ring-white/10">
                            <a href="{{ route('profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-slate-700">
                                <i class="ri-user-line text-base"></i>
                                User Info
                            </a>
                            <a href="{{ route('profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-slate-700">
                                <i class="ri-edit-line text-base"></i>
                                Edit Profile
                            </a>
                            <a href="{{ route('theme') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-slate-700">
                                <i class="ri-settings-line text-base"></i>
                                Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-red-500 hover:bg-red-50 dark:hover:bg-slate-700">
                                    <i class="ri-logout-box-r-line text-base"></i>
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 hover:border-[#FE9494] hover:text-[#FE9494]"
                        aria-label="Login">
                        <i class="ri-user-line text-xl"></i>
                    </a>
                @endif
            </div>

            {{-- Logo: centered on mobile, left on desktop --}}
            <a href="{{ route('home') }}"
                class="flex shrink-0 items-center absolute left-1/2 -translate-x-1/2 md:static md:translate-x-0 md:mr-8">
                <img class="h-10 w-auto" src="{{ asset('img/logo-petly.png') }}" alt="Petly">
            </a>

            <div class="hidden items-center gap-2 md:flex">
                <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-sm font-medium text-[#777] hover:text-[#FE9494] dark:text-gray-300 dark:hover:text-[#FE9494]">Home</a>
                <a href="{{ route('product.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-[#777] hover:text-[#FE9494] dark:text-gray-300 dark:hover:text-[#FE9494]">Products</a>
                <a href="{{ route('services') }}" class="rounded-md px-3 py-2 text-sm font-medium text-[#777] hover:text-[#FE9494] dark:text-gray-300 dark:hover:text-[#FE9494]">Services</a>
                <a href="{{ route('history') }}" class="rounded-md px-3 py-2 text-sm font-medium text-[#777] hover:text-[#FE9494] dark:text-gray-300 dark:hover:text-[#FE9494]">History</a>
                <a href="{{ route('about') }}" class="rounded-md px-3 py-2 text-sm font-medium text-[#777] hover:text-[#FE9494] dark:text-gray-300 dark:hover:text-[#FE9494]">About</a>
            </div>

            <div class="hidden items-center gap-3 md:flex">
                <form action="{{ route('product.index') }}" class="relative">
                    <input type="search" name="search" placeholder="Search"
                        class="h-10 w-44 rounded-full border border-gray-200 bg-white pl-9 pr-4 text-sm outline-none transition focus:border-[#FE9494] lg:w-60" />
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 stroke-gray-500"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>

                @if (session()->has('api_token'))
                    <a href="{{ route('cart.index') }}" class="rounded-full p-2 hover:bg-pink-50" aria-label="Open cart">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 stroke-gray-500 hover:stroke-[#FE9494]"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>

                    <div class="relative">
                        <button type="button" @click="userOpen = !userOpen"
                            class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full bg-gray-800 text-sm font-semibold text-white">
                            @if (session('profile_image'))
                                <img src="{{ asset(session('profile_image')) }}" alt="Profile" class="h-full w-full object-cover">
                            @else
                                {{ strtoupper(substr(session('username', 'U'), 0, 1)) }}
                            @endif
                        </button>

                        <div x-show="userOpen" @click.outside="userOpen = false" x-transition
                            class="absolute right-0 mt-2 w-48 overflow-hidden rounded-lg bg-white py-1 shadow-lg ring-1 ring-black/5 dark:bg-slate-800 dark:ring-white/10">
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-slate-700">Your Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-slate-700">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <button type="button" onclick="petlyRequireLogin('{{ route('login') }}')" class="rounded-full p-2 hover:bg-pink-50" aria-label="Open cart">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 stroke-gray-500 hover:stroke-[#FE9494]"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </button>

                    <a href="{{ route('login') }}"
                        class="rounded-lg bg-[#FE9494] px-4 py-2 text-sm font-semibold text-white hover:bg-[#FE7A7A]">
                        Login
                    </a>
                @endif
            </div>

            {{-- Mobile: cart + hamburger grouped on the right --}}
            <div class="flex w-20 shrink-0 items-center justify-end gap-0.5 md:hidden">
                @if (session()->has('api_token'))
                    <a href="{{ route('cart.index') }}" class="flex h-10 w-10 items-center justify-center rounded-full text-gray-600 hover:text-[#FE9494]" aria-label="Open cart">
                        <i class="ri-shopping-cart-line text-xl"></i>
                    </a>
                @else
                    <button type="button" onclick="petlyRequireLogin('{{ route('login') }}')" class="flex h-10 w-10 items-center justify-center rounded-full text-gray-600 hover:text-[#FE9494]" aria-label="Open cart">
                        <i class="ri-shopping-cart-line text-xl"></i>
                    </button>
                @endif

                <button type="button" @click="profileOpen = false; isOpen = !isOpen"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-600"
                    aria-label="Open menu">
                    <i class="ri-menu-line text-2xl" x-show="!isOpen"></i>
                    <i class="ri-close-line text-2xl" x-show="isOpen"></i>
                </button>
            </div>
        </div>

        <div x-show="isOpen" x-transition class="border-t border-gray-100 py-4 md:hidden dark:border-slate-700 dark:bg-slate-900">
            <form action="{{ route('product.index') }}" class="relative mb-4">
                <input type="search" name="search" placeholder="Search"
                    class="h-10 w-full rounded-full border border-gray-200 bg-white pl-9 pr-4 text-sm outline-none focus:border-[#FE9494] dark:border-slate-700 dark:bg-slate-800 dark:text-gray-200" />
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 stroke-gray-500"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </form>

            <div class="grid gap-1">
                <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-pink-50 dark:text-gray-200 dark:hover:bg-slate-800">Home</a>
                <a href="{{ route('product.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-pink-50 dark:text-gray-200 dark:hover:bg-slate-800">Products</a>
                <a href="{{ route('services') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-pink-50 dark:text-gray-200 dark:hover:bg-slate-800">Services</a>
                <a href="{{ route('history') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-pink-50 dark:text-gray-200 dark:hover:bg-slate-800">History</a>
                <a href="{{ route('about') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-pink-50 dark:text-gray-200 dark:hover:bg-slate-800">About</a>
            </div>

            <div class="mt-4 grid gap-2">
                @if (session()->has('api_token'))
                    <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 dark:border-slate-700 dark:bg-slate-800 dark:text-gray-200">
                        <i class="ri-shopping-cart-line text-lg"></i>
                        Cart
                    </a>
                @else
                    <button type="button" onclick="petlyRequireLogin('{{ route('login') }}')" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 dark:border-slate-700 dark:bg-slate-800 dark:text-gray-200">
                        <i class="ri-shopping-cart-line text-lg"></i>
                        Cart
                    </button>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg bg-[#FE9494] px-4 py-2 text-center text-sm font-semibold text-white">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>
