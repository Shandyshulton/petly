<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management</title>
    <x-favicon />
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

        <main class="w-full px-4 py-5 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-medium text-pink-500">Admin</p>
                        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Appointment Management</h1>
                        <p class="mt-1 text-sm text-gray-500">{{ $appointments->total() }} appointments</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.appointment.index') }}" class="mt-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="grid gap-3 lg:grid-cols-[minmax(0,1fr)_160px_160px_160px_160px_auto_auto]">
                        <div class="relative">
                            <label for="appointment-search" class="sr-only">Search appointments</label>
                            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input id="appointment-search" name="q" type="search" value="{{ $filters['q'] ?? '' }}" placeholder="Search customer, pet, service"
                                class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm shadow-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                        </div>
                        <select name="status" class="rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm outline-none focus:border-[#FE9494]">
                            <option value="">All statuses</option>
                            @foreach (['pending', 'approved', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <select name="service_type" class="rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm outline-none focus:border-[#FE9494]">
                            <option value="">All services</option>
                            <option value="grooming" @selected(($filters['service_type'] ?? '') === 'grooming')>Grooming</option>
                            <option value="clinic" @selected(($filters['service_type'] ?? '') === 'clinic')>Clinic</option>
                        </select>
                        <input name="date_from" type="date" value="{{ $filters['date_from'] ?? '' }}" class="rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm outline-none focus:border-[#FE9494]">
                        <input name="date_to" type="date" value="{{ $filters['date_to'] ?? '' }}" class="rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm outline-none focus:border-[#FE9494]">
                        <button type="submit" class="rounded-lg bg-[#FE9494] px-4 py-3 text-sm font-semibold text-white hover:bg-[#FE7A7A]">Filter</button>
                        <a href="{{ route('admin.appointment.index') }}" class="rounded-lg border border-gray-200 px-4 py-3 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50">Reset</a>
                    </div>
                </form>

                <div class="mt-6 grid grid-cols-2 gap-3 md:hidden">
                    @forelse ($appointments as $appointment)
                        <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                            <div class="p-4">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-gray-900">
                                        {{ $appointment->user->username ?? 'Unknown user' }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-400">Appointment #{{ $appointment->appointment_id }}</p>
                                </div>
                                <span class="mt-3 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $appointment->status === 'pending' ? 'bg-amber-50 text-amber-700' : ($appointment->status === 'approved' ? 'bg-green-50 text-green-700' : ($appointment->status === 'completed' ? 'bg-blue-50 text-blue-700' : 'bg-red-50 text-red-600')) }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>

                                <div class="mt-4 space-y-1.5 text-sm text-gray-600">
                                    <p class="capitalize"><span class="text-gray-400">Service:</span> {{ $appointment->service_type }}</p>
                                    <p><span class="text-gray-400">Date:</span> {{ $appointment->appointment_date }} · {{ $appointment->appointment_time }}</p>
                                    <p class="capitalize"><span class="text-gray-400">Pet:</span> {{ $appointment->pet_name }} ({{ $appointment->pet_species }})</p>
                                    @if ($appointment->pet_breed)
                                        <p class="capitalize"><span class="text-gray-400">Breed:</span> {{ $appointment->pet_breed }}</p>
                                    @endif
                                </div>

                                @if ($appointment->notes)
                                    <p class="mt-3 break-words rounded-md bg-gray-50 p-2.5 text-sm text-gray-500">{{ $appointment->notes }}</p>
                                @endif
                            </div>

                            <div class="border-t border-gray-100 bg-gray-50 px-4 py-3">
                                <form action="{{ route('admin.appointment.update', $appointment->appointment_id) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status"
                                        class="min-w-0 flex-1 rounded-md border border-gray-200 bg-white px-2 py-2 text-sm outline-none focus:border-[#FE9494]">
                                        @foreach (['pending', 'approved', 'completed', 'cancelled'] as $status)
                                            <option value="{{ $status }}" @selected($appointment->status === $status)>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                        class="shrink-0 rounded-md bg-[#FE9494] px-3 py-2 text-sm font-semibold text-white hover:bg-[#FE7A7A]">
                                        Update
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-lg border border-gray-200 bg-white p-6 text-center text-sm text-gray-500">
                            No appointments available.
                        </div>
                    @endforelse
                </div>

                <div class="mt-6 hidden overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm md:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">ID</th>
                                    <th class="px-6 py-3 font-semibold">Customer</th>
                                    <th class="px-6 py-3 font-semibold">Service</th>
                                    <th class="px-6 py-3 font-semibold">Date</th>
                                    <th class="px-6 py-3 font-semibold">Time</th>
                                    <th class="px-6 py-3 font-semibold">Pet</th>
                                    <th class="px-6 py-3 font-semibold">Status</th>
                                    <th class="px-6 py-3 font-semibold">Update Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($appointments as $appointment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-600">#{{ $appointment->appointment_id }}</td>
                                        <td class="px-6 py-4">
                                            <p class="font-medium text-gray-900">{{ $appointment->user->username ?? 'Unknown user' }}</p>
                                            <p class="text-xs text-gray-400">{{ $appointment->user->email ?? '' }}</p>
                                        </td>
                                        <td class="px-6 py-4 capitalize text-gray-600">{{ $appointment->service_type }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $appointment->appointment_date }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $appointment->appointment_time }}</td>
                                        <td class="px-6 py-4 capitalize text-gray-600">
                                            {{ $appointment->pet_name }} ({{ $appointment->pet_species }})
                                            @if ($appointment->pet_breed)
                                                <span class="block text-xs text-gray-400">{{ $appointment->pet_breed }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $appointment->status === 'pending' ? 'bg-amber-50 text-amber-700' : ($appointment->status === 'approved' ? 'bg-green-50 text-green-700' : ($appointment->status === 'completed' ? 'bg-blue-50 text-blue-700' : 'bg-red-50 text-red-600')) }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('admin.appointment.update', $appointment->appointment_id) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status"
                                                    class="rounded-md border border-gray-200 bg-white px-2 py-1.5 text-sm outline-none focus:border-[#FE9494]">
                                                    @foreach (['pending', 'approved', 'completed', 'cancelled'] as $status)
                                                        <option value="{{ $status }}" @selected($appointment->status === $status)>{{ ucfirst($status) }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit"
                                                    class="rounded-md bg-[#FE9494] px-3 py-1.5 text-sm font-semibold text-white hover:bg-[#FE7A7A]">
                                                    Update
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-10 text-center text-gray-500">No appointments available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-6">
                    {{ $appointments->links() }}
                </div>
            </div>
        </main>
    </div>
</body>

</html>
