<x-main>

    <section class="py-10 relative">
        <h2 class="font-semibold text-2xl  text-black mb-5">Transaction History</h2>
        @if (session()->has('api_token'))
            @if (!empty($transactions))

                @foreach ($transactions as $transaction)
                    <div class="mt-7 border border-gray-300 pt-9 rounded-lg">
                        <div class="flex max-md:flex-col items-center justify-between px-3 md:px-11">
                            <div class="data">
                                <p class="font-medium text-lg leading-8 text-black whitespace-nowrap">Order :
                                    #{{ $transaction['transaction_id'] }}</p>
                                <p class="font-medium text-lg leading-8 text-black mt-3 whitespace-nowrap">Order Payment
                                    :
                                    {{ $transaction['transaction_date'] }}</p>
                                <p class="font-medium text-lg leading-8 text-black mt-3 whitespace-nowrap">
                                    Status : <span
                                        class="uppercase">{{ $transaction['transaction_status']['transaction_status_name'] }}
                                    </span>
                                    {{-- Status : <span class="text-green-500">Completed</span> --}}
                                </p>
                            </div>
                            {{-- <form action="{{ route('single.checkout', $transaction['transaction_id']) }}" method="GET">
                            @csrf
                            <button type="submit"
                                class="rounded-full px-7 py-3 bg-[#FF9494] text-white font-semibold text-sm transition-all duration-500">
                                Pay Now
                            </button>
                        </form> --}}
                        </div>
                        <svg class="my-9 w-full" xmlns="http://www.w3.org/2000/svg" width="1216" height="2"
                            viewBox="0 0 1216 2" fill="none">
                            <path d="M0 1H1216" stroke="#D1D5DB" />
                        </svg>
                        {{-- @foreach ($transaction['cart'] as $cart) --}}
                        <div class="flex max-lg:flex-col items-center gap-8 lg:gap-24 px-3 md:px-11">
                            <div class="grid grid-cols-4 w-full">
                                <div class="col-span-4 sm:col-span-1">
                                    <img src="{{ $transaction['transaction_details']['product']['product_image'] }}"
                                        alt="sdawdadaw" class="max-sm:mx-auto object-cover">
                                </div>
                                <div
                                    class="col-span-4 sm:col-span-3 max-sm:mt-4 sm:pl-8 flex flex-col justify-center max-sm:items-center">
                                    <h6 class="font-semibold text-xl text-black mb-2">
                                        {{ $transaction['transaction_details']['product']['product_name'] }}
                                    </h6>
                                    {{-- <p class="text-md leading-8 text-gray-500 mb-8 whitespace-nowrap">Type: Dust Studios
                                </p> --}}
                                    <div class="flex items-center max-sm:flex-col gap-x-10 gap-y-3">
                                        <span class="text-lg leading-8 text-gray-500 whitespace-nowrap">Quantity:
                                            {{ $transaction['transaction_details']['quantity'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-around w-full sm:pl-28 lg:pl-0">
                                <div class="flex flex-col justify-center items-start max-sm:items-center">
                                    <p class="text-lg text-gray-500 leading-8 mb-2 text-left whitespace-nowrap">PRICE
                                    </p>
                                    <p class="font-semibold text-lg leading-8 text-black text-left whitespace-nowrap">
                                        IDR
                                        {{ $transaction['transaction_details']['product']['product_price'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="px-3 md:px-11 py-8 flex justify-end">
                            <p class="font-medium text-xl leading-8 text-black">Total Price:
                                <span class="text-gray-500">
                                    {{ $transaction['transaction_details']['total_payment'] }}</span>
                            </p>
                        </div>
                        {{-- @endforeach --}}
                    </div>
                @endforeach
            @else
                <div class="flex items-center justify-center h-screen">
                    <p class="font-medium text-xl text-gray-500">No Transactions Available</p>
                </div>
            @endif
        @else
            <div class="flex items-center justify-center h-screen">
                <p class="font-medium text-xl text-gray-500">You Need Login First!</p>
            </div>
        @endif
    </section>

</x-main>
