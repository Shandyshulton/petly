<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <script>
        (function () {
            var t = localStorage.getItem('theme');
            if (t === 'dark' || (!t && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-gray-100 dark:bg-slate-900">
    <x-toast />

    <div class="min-h-screen">
        <x-admin-navbar />

        <main class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-medium text-pink-500">Admin</p>
                        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Order Management</h1>
                        <p class="mt-1 text-sm text-gray-500">{{ $transactions->total() }} orders</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.order.index') }}" class="mt-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="grid gap-3 lg:grid-cols-[minmax(0,1fr)_180px_160px_160px_auto_auto]">
                        <div class="relative">
                            <label for="order-search" class="sr-only">Search orders</label>
                            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input id="order-search" name="q" type="search" value="{{ $filters['q'] ?? '' }}" placeholder="Search order, customer, status"
                                class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm shadow-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                        </div>
                        <select name="status" class="rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm outline-none focus:border-[#FE9494]">
                            <option value="">All statuses</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <input name="date_from" type="date" value="{{ $filters['date_from'] ?? '' }}" class="rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm outline-none focus:border-[#FE9494]">
                        <input name="date_to" type="date" value="{{ $filters['date_to'] ?? '' }}" class="rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm outline-none focus:border-[#FE9494]">
                        <button type="submit" class="rounded-lg bg-[#FE9494] px-4 py-3 text-sm font-semibold text-white hover:bg-[#FE7A7A]">Filter</button>
                        <a href="{{ route('admin.order.index') }}" class="rounded-lg border border-gray-200 px-4 py-3 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50">Reset</a>
                    </div>
                </form>

                <div class="mt-6 grid grid-cols-2 gap-3 md:hidden">
                    @forelse ($transactions as $transaction)
                        <article class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-gray-900">{{ $transaction->users->username ?? 'Unknown user' }}</p>
                                <p class="mt-1 text-xs text-gray-400">Order #{{ $transaction->transaction_id }}</p>
                            </div>
                            <span class="mt-3 inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold uppercase text-gray-600">
                                {{ $transaction->transactionStatus->transaction_status_name ?? '-' }}
                            </span>

                            <div class="mt-4 space-y-1.5 text-sm text-gray-600">
                                <p><span class="text-gray-400">Total:</span> IDR {{ number_format($transaction->transactionDetails->total_payment ?? 0, 0, ',') }}</p>
                                <p><span class="text-gray-400">Items:</span> {{ $transaction->transactionDetails->quantity ?? 0 }} pcs</p>
                                <p><span class="text-gray-400">Date:</span> {{ $transaction->transaction_date }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-lg border border-gray-200 bg-white p-6 text-center text-sm text-gray-500">
                            No data available.
                        </div>
                    @endforelse
                </div>

                <div class="mt-6 hidden overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm md:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Customer Name</th>
                                    <th class="px-6 py-3 font-semibold">Order ID</th>
                                    <th class="px-6 py-3 font-semibold">Total Price</th>
                                    <th class="px-6 py-3 font-semibold">Total Items</th>
                                    <th class="px-6 py-3 font-semibold">Status</th>
                                    <th class="px-6 py-3 font-semibold">Transaction Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($transactions as $transaction)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $transaction->users->username ?? 'Unknown user' }}</td>
                                        <td class="px-6 py-4 text-gray-600">#{{ $transaction->transaction_id }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">IDR {{ number_format($transaction->transactionDetails->total_payment ?? 0, 0, ',') }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $transaction->transactionDetails->quantity ?? 0 }} pcs</td>
                                        <td class="px-6 py-4">
                                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold uppercase text-gray-600">
                                                {{ $transaction->transactionStatus->transaction_status_name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">{{ $transaction->transaction_date }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">No data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-6">
                    {{ $transactions->links() }}
                </div>
            </div>
        </main>
    </div>
</body>

</html>
