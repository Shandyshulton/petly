<x-main>

    <section class="py-8 sm:py-10 relative">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h2 class="font-semibold text-2xl text-black">History</h2>
        </div>

        @if (!session()->has('api_token'))
            <div class="flex items-center justify-center h-72">
                <div class="text-center">
                    <p class="font-medium text-xl text-gray-500">You Need Login First!</p>
                    <a href="{{ route('login') }}"
                        class="mt-4 inline-block rounded-lg bg-[#FE9494] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[#FE7A7A]">
                        Login
                    </a>
                </div>
            </div>
        @else
            {{-- Tabs --}}
            <div class="flex gap-2 border-b border-gray-200 mb-4" role="tablist" aria-label="History tabs">
                <a href="{{ route('history', ['tab' => 'shop']) }}" role="tab" aria-selected="{{ $tab === 'shop' ? 'true' : 'false' }}"
                    class="px-4 py-3 text-sm font-medium border-b-2 -mb-px transition-colors
                    {{ $tab === 'shop' ? 'border-[#FE9494] text-[#FE9494]' : 'border-transparent text-gray-500 hover:text-gray-800' }}">
                    Shop
                </a>
                <a href="{{ route('history', ['tab' => 'appointment']) }}" role="tab" aria-selected="{{ $tab === 'appointment' ? 'true' : 'false' }}"
                    class="px-4 py-3 text-sm font-medium border-b-2 -mb-px transition-colors
                    {{ $tab === 'appointment' ? 'border-[#FE9494] text-[#FE9494]' : 'border-transparent text-gray-500 hover:text-gray-800' }}">
                    Appointment
                </a>
            </div>

            {{-- Sub-tab status --}}
            @if ($tab === 'shop')
                @php
                    $shopStatuses = ['pending', 'progress', 'complete', 'canceled'];
                    $statusLabels = ['pending' => 'Pending', 'progress' => 'Progress', 'complete' => 'Complete', 'canceled' => 'Canceled'];
                @endphp
            @else
                @php
                    $shopStatuses = ['pending', 'approved', 'completed', 'cancelled'];
                    $statusLabels = ['pending' => 'Pending', 'approved' => 'Approved', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
                @endphp
            @endif

            <div class="flex flex-wrap gap-2 mb-8" role="tablist" aria-label="Status tabs">
                <a href="{{ route('history', ['tab' => $tab]) }}" role="tab" aria-selected="{{ $status === null ? 'true' : 'false' }}"
                    class="px-3 py-1.5 text-xs font-semibold rounded-full border transition-colors
                    {{ $status === null ? 'bg-[#FE9494] border-[#FE9494] text-white' : 'border-gray-300 text-gray-600 hover:border-[#FE9494] hover:text-[#FE9494]' }}">
                    All
                </a>
                @foreach ($shopStatuses as $s)
                    <a href="{{ route('history', ['tab' => $tab, 'status' => $s]) }}" role="tab" aria-selected="{{ $status === $s ? 'true' : 'false' }}"
                        class="px-3 py-1.5 text-xs font-semibold rounded-full border transition-colors
                        {{ $status === $s ? 'bg-[#FE9494] border-[#FE9494] text-white' : 'border-gray-300 text-gray-600 hover:border-[#FE9494] hover:text-[#FE9494]' }}">
                        {{ $statusLabels[$s] }}
                    </a>
                @endforeach
            </div>

            @if ($tab === 'shop')
                @if (count($transactions) > 0)
                    <div class="space-y-6">
                        @foreach ($transactions as $transaction)
                            <div class="border border-gray-300 rounded-lg overflow-hidden">
                                <div class="px-4 sm:px-8 pt-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <div class="space-y-1.5">
                                            <p class="font-medium text-base sm:text-lg text-black break-words">Order :
                                                #{{ $transaction['transaction_id'] }}</p>
                                            <p class="font-medium text-sm sm:text-lg text-black">Order Payment :
                                                {{ $transaction['transaction_date'] }}</p>
                                            <p class="font-medium text-sm sm:text-lg text-black">Status :
                                                <span
                                                    class="uppercase text-xs sm:text-sm px-2 py-0.5 rounded-full bg-gray-100">
                                                    {{ $transaction['transaction_status']['transaction_status_name'] }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-5 border-gray-200">

                                <div class="px-4 sm:px-8 flex flex-col sm:flex-row gap-6">
                                    <div class="flex items-center gap-4 sm:gap-8 flex-1 min-w-0">
                                        <img src="{{ $transaction['transaction_details']['product']['product_image'] }}"
                                            alt="{{ $transaction['transaction_details']['product']['product_name'] }}"
                                            class="w-20 h-20 sm:w-28 sm:h-28 object-cover rounded-lg shrink-0">
                                        <div class="min-w-0">
                                            <h6 class="font-semibold text-base sm:text-xl text-black break-words">
                                                {{ $transaction['transaction_details']['product']['product_name'] }}
                                            </h6>
                                            <span class="block text-sm sm:text-lg text-gray-500 mt-2 break-words">Quantity:
                                                {{ $transaction['transaction_details']['quantity'] }}</span>
                                            <span class="block text-sm sm:text-lg text-gray-500 mt-1 break-words">Price:
                                                IDR {{ $transaction['transaction_details']['product']['product_price'] }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-4 sm:px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 border-t border-gray-100 mt-6">
                                    <p class="font-medium text-base sm:text-xl text-black">Total Price:
                                        <span class="text-gray-500">{{ $transaction['transaction_details']['total_payment'] }}</span>
                                    </p>

                                    @if (strtolower($transaction['transaction_status']['transaction_status_name'] ?? '') === 'pending')
                                        <form method="POST" action="{{ route('checkout.resume') }}">
                                            @csrf
                                            <input type="hidden" name="transaction_ids[]" value="{{ $transaction['transaction_id'] }}">
                                            <button type="submit"
                                                class="inline-flex items-center gap-2 rounded-lg bg-[#FE9494] px-4 py-2 text-sm font-semibold text-white hover:bg-[#FE7A7A]">
                                                <i class="ri-play-circle-line"></i>
                                                Lanjutkan Pembayaran
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-center justify-center h-72">
                        <p class="font-medium text-xl text-gray-500">No Transactions Available</p>
                    </div>
                @endif
            @else
                @if ($appointments->isNotEmpty())
                    <div class="space-y-6">
                        @foreach ($appointments as $appointment)
                            <div class="border border-gray-300 rounded-lg overflow-hidden">
                                <div class="px-4 sm:px-8 pt-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <p class="font-medium text-base sm:text-lg text-black break-words">
                                            Appointment : #{{ $appointment->appointment_id }}
                                        </p>
                                        <span
                                            class="inline-flex self-start sm:self-auto px-3 py-1 rounded-full text-xs font-semibold uppercase
                                            {{ $appointment->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($appointment->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600') }}">
                                            {{ $appointment->status }}
                                        </span>
                                    </div>
                                </div>

                                <hr class="my-5 border-gray-200">

                                <div class="px-4 sm:px-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-4">
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">Service</p>
                                        <p class="font-medium text-sm text-black capitalize break-words">{{ $appointment->service_type }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">Date</p>
                                        <p class="font-medium text-sm text-black">{{ $appointment->appointment_date }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">Time</p>
                                        <p class="font-medium text-sm text-black">{{ $appointment->appointment_time }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">Pet</p>
                                        <p class="font-medium text-sm text-black capitalize break-words">
                                            {{ $appointment->pet_name }} ({{ $appointment->pet_species }})
                                            @if ($appointment->pet_breed)
                                                · {{ $appointment->pet_breed }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                @if ($appointment->notes)
                                    <div class="px-4 sm:px-8 mt-5">
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">Notes</p>
                                        <p class="font-medium text-sm text-gray-600 break-words">{{ $appointment->notes }}</p>
                                    </div>
                                @endif

                                <div class="px-4 sm:px-8 py-6 mt-4 border-t border-gray-100">
                                    <p class="text-sm text-gray-500">Booked on
                                        {{ $appointment->created_at ? $appointment->created_at->format('d M Y') : '-' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-center justify-center h-72">
                        <div class="text-center">
                            <p class="font-medium text-xl text-gray-500">No Appointments Yet</p>
                            <a href="{{ route('services') }}"
                                class="mt-4 inline-block rounded-lg bg-[#FE9494] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[#FE7A7A]">
                                Book an Appointment
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        @endif
    </section>

</x-main>
