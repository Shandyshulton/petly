<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
                        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">User Management</h1>
                        <p class="mt-1 text-sm text-gray-500">{{ $users->total() }} users</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.user.index') }}" class="mt-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="grid gap-3 lg:grid-cols-[minmax(0,1fr)_180px_auto_auto]">
                        <div class="relative">
                            <label for="user-search" class="sr-only">Search users</label>
                            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input id="user-search" name="q" type="search" value="{{ $filters['q'] ?? '' }}" placeholder="Search users by name, email, phone, role"
                                class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm shadow-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                        </div>
                        <select name="role" class="rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm outline-none focus:border-[#FE9494]">
                            <option value="">All roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->role_id }}" @selected(($filters['role'] ?? '') == $role->role_id)>{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="rounded-lg bg-[#FE9494] px-4 py-3 text-sm font-semibold text-white hover:bg-[#FE7A7A]">Filter</button>
                        <a href="{{ route('admin.user.index') }}" class="rounded-lg border border-gray-200 px-4 py-3 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50">Reset</a>
                    </div>
                </form>

                <div class="mt-6 grid grid-cols-2 gap-3 md:hidden">
                    @forelse ($users as $user)
                        <article class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-gray-900">{{ $user->username }}</p>
                                <p class="mt-1 text-xs text-gray-400">#{{ $user->user_id }}</p>
                                <span class="mt-2 inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                    {{ $user->role->role_name ?? '-' }}
                                </span>
                            </div>

                            <div class="mt-4 space-y-1.5 text-sm">
                                <p class="break-words text-gray-600"><i class="ri-mail-line mr-2 text-gray-400"></i>{{ $user->email }}</p>
                                <p class="text-gray-600"><i class="ri-phone-line mr-2 text-gray-400"></i>{{ $user->phone_number ?? '-' }}</p>
                            </div>

                            <div class="mt-4 flex gap-2">
                                @if ($user->role_role_id == 2)
                                    <a href="{{ route('admin.user.edit-courier', $user->user_id) }}"
                                        class="flex-1 rounded-md bg-[#FE9494] px-3 py-1.5 text-center text-xs font-medium text-white hover:bg-[#FE7A7A]">
                                        Edit
                                    </a>
                                @endif
                                <form action="{{ route('admin.user.destroy', $user->user_id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full rounded-md bg-red-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-600"
                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-lg border border-gray-200 bg-white p-6 text-center text-sm text-gray-500">
                            No users available.
                        </div>
                    @endforelse
                </div>

                <div class="mt-6 hidden overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm md:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">User ID</th>
                                    <th class="px-6 py-3 font-semibold">User Name</th>
                                    <th class="px-6 py-3 font-semibold">Role</th>
                                    <th class="px-6 py-3 font-semibold">Phone Number</th>
                                    <th class="px-6 py-3 font-semibold">Email</th>
                                    <th class="px-6 py-3 text-right font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-600">#{{ $user->user_id }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $user->username }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $user->role->role_name ?? '-' }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $user->phone_number ?? '-' }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-2">
                                                @if ($user->role_role_id == 2)
                                                    <a href="{{ route('admin.user.edit-courier', $user->user_id) }}"
                                                        class="rounded-md bg-[#FE9494] px-3 py-2 text-sm font-medium text-white hover:bg-[#FE7A7A]">
                                                        Edit
                                                    </a>
                                                @endif
                                                <form action="{{ route('admin.user.destroy', $user->user_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="rounded-md bg-red-500 px-3 py-2 text-sm font-medium text-white hover:bg-red-600"
                                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">No users available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </main>
    </div>
</body>

</html>
