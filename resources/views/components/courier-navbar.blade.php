@once
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endonce

@php
    $courierLinks = [
        ['route' => 'courier.info', 'label' => 'Courier Info', 'icon' => 'ri-user-line', 'active' => 'courier.info'],
        ['route' => 'courier.tracking', 'label' => 'Parcel Tracking', 'icon' => 'ri-truck-line', 'active' => 'courier.tracking'],
    ];
@endphp

<div x-data="{ mobileOpen: false }">
    {{-- ============================================================
         DESKTOP SIDEBAR (lg and up) — fixed di kiri
    ============================================================ --}}
    <aside class="hidden lg:fixed lg:inset-y-0 lg:left-0 lg:z-40 lg:flex lg:w-64 lg:flex-col lg:border-r lg:border-gray-100 lg:bg-[#FBFCFF] dark:lg:border-slate-700 dark:lg:bg-slate-900">
        {{-- Logo --}}
        <div class="flex h-20 shrink-0 items-center gap-3 px-6">
            <img class="h-10 w-auto" src="{{ asset('img/logo-petly.png') }}" alt="Petly">
        </div>

        {{-- Nav links --}}
        <nav class="flex-1 space-y-1 px-4 py-4">
            @foreach ($courierLinks as $link)
                @php $isActive = request()->routeIs($link['active']); @endphp
                <a href="{{ route($link['route']) }}"
                    class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-semibold transition {{ $isActive ? 'bg-pink-50 text-pink-500 dark:bg-slate-800' : 'text-gray-600 hover:bg-gray-50 hover:text-[#FE9494] dark:text-gray-300 dark:hover:bg-slate-800' }}">
                    <i class="{{ $link['icon'] }} text-xl"></i>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Bottom: profile + actions --}}
        <div class="border-t border-gray-100 p-4 dark:border-slate-700" x-data="{ open: false }">
            <div class="relative">
                <button type="button" @click="open = !open"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-left transition hover:bg-gray-50 dark:hover:bg-slate-800">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-full border border-gray-200 bg-white text-gray-600">
                        @if (session('profile_image'))
                            <img src="{{ asset(session('profile_image')) }}" alt="Profile" class="h-full w-full object-cover">
                        @else
                            <i class="ri-user-line text-lg"></i>
                        @endif
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-semibold text-gray-900 dark:text-gray-100">{{ session('username', 'Courier') }}</span>
                        <span class="block text-xs text-gray-500">Courier</span>
                    </span>
                    <i class="ri-arrow-up-s-line text-lg text-gray-400" x-show="open"></i>
                    <i class="ri-arrow-down-s-line text-lg text-gray-400" x-show="!open"></i>
                </button>

                <div x-show="open" @click.outside="open = false" x-transition
                    class="absolute bottom-14 left-0 w-full overflow-hidden rounded-lg bg-white py-1 shadow-lg ring-1 ring-black/5 dark:bg-slate-800 dark:ring-white/10">
                    <a href="{{ route('courier.theme') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-slate-700">
                        <i class="ri-palette-line text-base"></i>
                        Theme
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-red-500 hover:bg-red-50 dark:hover:bg-slate-700">
                            <i class="ri-logout-box-r-line text-base"></i>
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
            <div class="mt-2 flex justify-center">
                <x-theme-toggle />
            </div>
        </div>
    </aside>

    {{-- ============================================================
         MOBILE TOP BAR (< lg) — hamburger membuka drawer
    ============================================================ --}}
    <nav class="sticky top-0 z-40 bg-[#FBFCFF] shadow-sm lg:hidden dark:bg-slate-900">
        <div class="flex min-h-16 items-center justify-between gap-4 px-4 sm:px-6">
            <button type="button" @click="mobileOpen = true"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-600 transition hover:border-[#FE9494] hover:text-[#FE9494]"
                aria-label="Open courier menu">
                <i class="ri-menu-line text-2xl"></i>
            </button>

            <a href="{{ route('courier.info') }}" class="flex items-center">
                <img class="h-9 w-auto" src="{{ asset('img/logo-petly.png') }}" alt="Petly">
            </a>

            <x-theme-toggle />
        </div>
    </nav>

    {{-- Mobile drawer overlay --}}
    <div x-show="mobileOpen" x-transition.opacity @click="mobileOpen = false"
        class="fixed inset-0 z-40 bg-black/40 lg:hidden" style="display: none;"></div>

    {{-- Mobile drawer panel --}}
    <aside x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 z-50 flex w-72 max-w-[80%] flex-col bg-[#FBFCFF] shadow-xl lg:hidden dark:bg-slate-900"
        style="display: none;">
        <div class="flex h-16 shrink-0 items-center justify-between px-5">
            <img class="h-9 w-auto" src="{{ asset('img/logo-petly.png') }}" alt="Petly">
            <button type="button" @click="mobileOpen = false"
                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-slate-800"
                aria-label="Close menu">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>

        <nav class="flex-1 space-y-1 px-4 py-2">
            @foreach ($courierLinks as $link)
                @php $isActive = request()->routeIs($link['active']); @endphp
                <a href="{{ route($link['route']) }}" @click="mobileOpen = false"
                    class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-semibold transition {{ $isActive ? 'bg-pink-50 text-pink-500 dark:bg-slate-800' : 'text-gray-600 hover:bg-gray-50 hover:text-[#FE9494] dark:text-gray-300 dark:hover:bg-slate-800' }}">
                    <i class="{{ $link['icon'] }} text-xl"></i>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="border-t border-gray-100 p-4 dark:border-slate-700">
            <div class="mb-3 flex items-center gap-3 px-2">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-full border border-gray-200 bg-white text-gray-600">
                    @if (session('profile_image'))
                        <img src="{{ asset(session('profile_image')) }}" alt="Profile" class="h-full w-full object-cover">
                    @else
                        <i class="ri-user-line text-lg"></i>
                    @endif
                </span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-gray-900 dark:text-gray-100">{{ session('username', 'Courier') }}</p>
                    <p class="text-xs text-gray-500">Courier</p>
                </div>
            </div>
            <a href="{{ route('courier.theme') }}"
                class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-slate-800">
                <i class="ri-palette-line text-base"></i>
                Theme
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm text-red-500 hover:bg-red-50 dark:hover:bg-slate-800">
                    <i class="ri-logout-box-r-line text-base"></i>
                    Sign out
                </button>
            </form>
        </div>
    </aside>
</div>
