@once
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endonce

@php
    $courierLinks = [
        ['route' => 'courier.info', 'label' => 'Courier Info', 'icon' => 'ri-user-line', 'active' => 'courier.info'],
        ['route' => 'courier.tracking', 'label' => 'Parcel Tracking', 'icon' => 'ri-truck-line', 'active' => 'courier.tracking'],
    ];
@endphp

<nav class="sticky top-0 z-40 bg-[#FBFCFF] shadow-sm dark:bg-slate-900" x-data="{ menuOpen: false, profileOpen: false }">
    <div class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-8">
        <div class="relative flex min-h-20 items-center justify-between gap-4">
            <div class="flex w-20 shrink-0 items-center">
                <div class="relative">
                    <button type="button" @click="menuOpen = false; profileOpen = !profileOpen"
                        class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full border border-gray-200 bg-white text-gray-600 transition hover:border-[#FE9494] hover:text-[#FE9494]"
                        aria-label="Courier profile">
                        @if (session('profile_image'))
                            <img src="{{ asset(session('profile_image')) }}" alt="Profile" class="h-full w-full object-cover">
                        @else
                            <i class="ri-user-line text-xl"></i>
                        @endif
                    </button>

                    <div x-show="profileOpen" @click.outside="profileOpen = false" x-transition
                        class="absolute left-0 top-12 w-48 overflow-hidden rounded-lg bg-white py-1 shadow-lg ring-1 ring-black/5 dark:bg-slate-800 dark:ring-white/10">
                        <div class="border-b border-gray-100 px-4 py-3 dark:border-slate-700">
                            <p class="text-sm font-semibold text-gray-900">{{ session('username', 'Courier') }}</p>
                            <p class="text-xs text-gray-500">Courier</p>
                        </div>
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
            </div>

            <a href="{{ route('courier.info') }}" class="absolute left-1/2 flex shrink-0 -translate-x-1/2 items-center">
                <img class="h-10 w-auto" src="{{ asset('img/logo-petly.png') }}" alt="Petly">
            </a>

            <div class="flex w-20 shrink-0 items-center justify-end">
                <button type="button" @click="profileOpen = false; menuOpen = !menuOpen"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-600 transition hover:border-[#FE9494] hover:text-[#FE9494]"
                    aria-label="Open courier menu">
                    <i class="ri-menu-line text-2xl" x-show="!menuOpen"></i>
                    <i class="ri-close-line text-2xl" x-show="menuOpen"></i>
                </button>
            </div>
        </div>

        <div x-show="menuOpen" x-transition class="border-t border-gray-100 py-4 dark:border-slate-700">
            <div class="grid gap-2 sm:grid-cols-2">
                @foreach ($courierLinks as $link)
                    @php
                        $isActive = request()->routeIs($link['active']);
                    @endphp
                    <a href="{{ route($link['route']) }}"
                        class="flex items-center gap-3 rounded-lg border px-4 py-3 text-sm font-semibold transition {{ $isActive ? 'border-[#FE9494] bg-pink-50 text-pink-500' : 'border-gray-200 bg-white text-gray-700 hover:border-[#FE9494] hover:text-[#FE9494]' }}">
                        <i class="{{ $link['icon'] }} text-xl"></i>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</nav>
