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
                    <a href="#"
                        class="ms-1 text-sm font-medium text-[#FE9494] hover:text-[#FE7070] md:ms-2">Product</a>
                </div>
            </li>
        </ol>
    </nav>
    </div>

    <section>
        <div class="mx-auto max-w-screen-2xl px-4 py-6 sm:px-6 lg:px-8">

            <div class="grid grid-cols-12">
                <div class="col-span-12 md:col-span-3 w-full max-md:max-w-md max-md:mx-auto">
                    <p class="font-semibold text-2xl leading-7 text-black">Filter</p>
                    <div class="mt-3 rounded-xl bg-white p-6 w-full md:max-w-xs shadow-md">
                        <div class="w-full mb-7">
                            <form class="hidden lg:block">

                                <div class="border-b border-gray-200 py-6" x-data="{ isOpen: false }">
                                    <h3 class="-my-3 flow-root">
                                        <!-- Expand/collapse section button -->
                                        <button type="button"
                                            class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
                                            @click="isOpen = !isOpen" :aria-expanded="isOpen">
                                            <span class="font-semibold text-sm text-gray-900">Category</span>

                                            <span class="ml-6 flex items-center">
                                                <!-- Expand icon, show/hide based on section open state. -->
                                                <svg class="size-5" :class="{ 'hidden': isOpen }" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                                </svg>
                                                <!-- Collapse icon, show/hide based on section open state. -->
                                                <svg class="size-5" :class="{ 'hidden': !isOpen }" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>

                                    <!-- Filter section, show/hide based on section state. -->
                                    <div class="pt-6" x-show="isOpen" x-collapse>
                                        <div class="space-y-4">
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-color-0" name="color[]" value="white"
                                                            type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-color-0"
                                                    class="text-sm text-gray-600">Accessories</label>
                                            </div>
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-color-1" name="color[]" value="beige"
                                                            type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-color-1" class="text-sm text-gray-600">Food</label>
                                            </div>
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-color-2" name="color[]" value="beige"
                                                            type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-color-2"
                                                    class="text-sm text-gray-600">Medicine</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-b border-gray-200 py-6" x-data="{ isOpen: false }">
                                    <h3 class="-my-3 flow-root">
                                        <!-- Expand/collapse section button -->
                                        <button type="button"
                                            class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
                                            @click="isOpen = !isOpen" :aria-expanded="isOpen">
                                            <span class="font-semibold text-sm text-gray-900">Animal Type</span>
                                            <span class="ml-6 flex items-center">
                                                <!-- Expand icon, show/hide based on section open state. -->
                                                <svg class="size-5" :class="{ 'hidden': isOpen }" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                                </svg>
                                                <!-- Collapse icon, show/hide based on section open state. -->
                                                <svg class="size-5" :class="{ 'hidden': !isOpen }" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <!-- Filter section, show/hide based on section state. -->
                                    <div class="pt-6" x-show="isOpen" x-collapse>
                                        <div class="space-y-4">
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-category-0" name="category[]"
                                                            value="new-arrivals" type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-category-0"
                                                    class="text-sm text-gray-600">Dog</label>
                                            </div>
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-category-1" name="category[]"
                                                            value="sale" type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-category-1"
                                                    class="text-sm text-gray-600">Cat</label>
                                            </div>
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-category-2" name="category[]"
                                                            value="organization" type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-category-2"
                                                    class="text-sm text-gray-600">Rabbit</label>
                                            </div>
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-category-3" name="category[]"
                                                            value="accessories" type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-category-3"
                                                    class="text-sm text-gray-600">Turtle</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-b border-gray-200 py-6">
                                    <h3 class="-my-3 flow-root">
                                        <span class="font-semibold text-sm text-gray-900">Price</span>
                                    </h3>
                                    <!-- Filter section, show/hide based on section state. -->
                                    <div class="pt-6">
                                        <div class="space-y-4">
                                            <div>
                                                <label for="FilterPriceFrom" class="flex items-center gap-2">
                                                    <span class="text-sm text-gray-600">Rp</span>
                                                    <input type="number" id="FilterPriceFrom"
                                                        placeholder="Harga Minimum"
                                                        class="w-full rounded-md border-1 border-gray-200 shadow-xs sm:text-sm py-2 pl-4" />
                                                </label>
                                            </div>
                                            <div>
                                                <label for="FilterPriceTo" class="flex items-center gap-2">
                                                    <span class="text-sm text-gray-600">Rp</span>
                                                    <input type="number" id="FilterPriceTo"
                                                        placeholder="Harga Maksimum"
                                                        class="w-full rounded-md border-1 border-gray-200 shadow-xs sm:text-sm py-2 pl-4" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="border-b border-gray-200 py-6" x-data="{ isOpen: false }">
                                    <h3 class="-my-3 flow-root">
                                        <!-- Expand/collapse section button -->
                                        <button type="button"
                                            class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
                                            @click="isOpen = !isOpen" :aria-expanded="isOpen">
                                            <span class="font-semibold text-sm text-gray-900">Sort By</span>
                                            <span class="ml-6 flex items-center">
                                                <!-- Expand icon, show/hide based on section open state. -->
                                                <svg class="size-5" :class="{ 'hidden': isOpen }" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                                </svg>
                                                <!-- Collapse icon, show/hide based on section open state. -->
                                                <svg class="size-5" :class="{ 'hidden': !isOpen }" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <!-- Filter section, show/hide based on section state. -->
                                    <div class="pt-6" x-show="isOpen" x-collapse>
                                        <div class="space-y-4">
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-size-0" name="size[]" value="2l"
                                                            type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-size-0"
                                                    class="text-sm text-gray-600">Latest</label>
                                            </div>
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-size-1" name="size[]" value="6l"
                                                            type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-size-1" class="text-sm text-gray-600">Highest
                                                    Price</label>
                                            </div>
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-size-2" name="size[]" value="12l"
                                                            type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-size-2" class="text-sm text-gray-600">Lowest
                                                    Price</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mt-5 box rounded-xl w-full md:max-w-xs">
                        <figure class="relative w-full h-full flex items-center justify-center">
                            <a href="#">
                                <img class="rounded-xl" src="{{ URL('img/banner-promotion.jpg') }}"
                                    alt="image description">
                            </a>
                            <figcaption class="absolute top-4 right-4 px-4 text-lg text-black">
                                <p>Pet care for pet care for pet care with pet care</p>
                            </figcaption>
                        </figure>
                    </div>

                </div>

                <div class="col-span-12 md:col-span-9">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                        <!-- Product Card 1 (Original) -->
                        @foreach ($products['data'] as $product)
                            <!-- Product Card -->
                            <div
                                class="bg-white shadow-md hover:scale-102 hover:shadow-xl duration-500 rounded-xl w-full">
                                <a href="{{ url('/detailproduct/' . $product['product_id']) }}">
                                    <img src="{{ $product['product_image'] ?? 'https://images.unsplash.com/photo-1526947425960-945c6e72858f?crop=entropy&cs=tinysrgb&fm=jpg&ixid=MnwzMjM4NDZ8MHwxfHJhbmRvbXx8fHx8fHx8fDE2NTgzODM0NDU&ixlib=rb-1.2.1&q=80' }}"
                                        class="h-60 w-full object-cover rounded-t-xl" />
                                </a>
                                <div class="px-3 py-2">
                                    <span
                                        class="text-gray-400 uppercase text-xs">{{ $product['product_type']['product_type_name'] }}</span>
                                    <p class="text-base font-semibold text-black truncate capitalize">
                                        {{ $product['product_name'] }}</p>
                                    <div class="flex items-center mt-1">
                                        <p class="text-lg font-semibold text-black">IDR
                                            {{ number_format($product['product_price'], 0, ',') }}</p>
                                        <div class="ml-auto">
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="#FFA4A4" class="bi bi-bag-plus" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z" />
                                                    <path
                                                        d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-main>
