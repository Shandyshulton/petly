<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
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

        <main class="w-full px-4 py-5 sm:px-6 lg:px-8 lg:pl-72">
            <div class="mx-auto max-w-7xl">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-medium text-pink-500">Admin</p>
                        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Product Management</h1>
                        <p class="mt-1 text-sm text-gray-500">{{ $products->total() }} products</p>
                    </div>

                    <a href="{{ route('admin.product.add') }}"
                        class="inline-flex w-full items-center justify-center rounded-lg bg-[#FE9494] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#FE7A7A] sm:w-auto">
                        <i class="ri-add-line mr-2 text-lg"></i>
                        Add Product
                    </a>
                </div>

                <form method="GET" action="{{ route('admin.product.index') }}" class="mt-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="grid gap-3 lg:grid-cols-[minmax(0,1fr)_180px_180px_160px_auto_auto]">
                        <div class="relative">
                            <label for="product-search" class="sr-only">Search products</label>
                            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input id="product-search" name="q" type="search" value="{{ $filters['q'] ?? '' }}" placeholder="Search product, category, pet"
                                class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm shadow-sm outline-none transition focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20">
                        </div>
                        <select name="product_type" class="rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm outline-none focus:border-[#FE9494]">
                            <option value="">All categories</option>
                            @foreach ($productTypes as $type)
                                <option value="{{ $type->product_type_id }}" @selected(($filters['product_type'] ?? '') == $type->product_type_id)>{{ $type->product_type_name }}</option>
                            @endforeach
                        </select>
                        <select name="pet_type" class="rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm outline-none focus:border-[#FE9494]">
                            <option value="">All pet types</option>
                            @foreach ($petTypes as $type)
                                <option value="{{ $type->pet_type_id }}" @selected(($filters['pet_type'] ?? '') == $type->pet_type_id)>{{ $type->pet_type_name }}</option>
                            @endforeach
                        </select>
                        <select name="stock" class="rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm outline-none focus:border-[#FE9494]">
                            <option value="">All stock</option>
                            <option value="available" @selected(($filters['stock'] ?? '') === 'available')>Available</option>
                            <option value="out" @selected(($filters['stock'] ?? '') === 'out')>Out of stock</option>
                        </select>
                        <button type="submit" class="rounded-lg bg-[#FE9494] px-4 py-3 text-sm font-semibold text-white hover:bg-[#FE7A7A]">Filter</button>
                        <a href="{{ route('admin.product.index') }}" class="rounded-lg border border-gray-200 px-4 py-3 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50">Reset</a>
                    </div>
                </form>

                <div class="mt-6 grid grid-cols-2 gap-3 md:hidden">
                    @forelse ($products as $product)
                        <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                            <div class="p-3">
                                <img src="{{ $product->product_image }}" alt="{{ $product->product_name }}"
                                    class="aspect-square w-full rounded-md object-cover">
                                <div class="mt-3 min-w-0">
                                    <p class="line-clamp-2 min-h-10 text-sm font-semibold text-gray-900">{{ $product->product_name }}</p>
                                    <p class="mt-1 truncate text-xs uppercase text-gray-400">{{ $product->productType->product_type_name ?? '-' }}</p>
                                    <p class="mt-2 text-sm font-semibold text-gray-900">IDR {{ number_format($product->product_price, 0, ',') }}</p>
                                </div>
                            </div>

                            <div class="space-y-2 border-t border-gray-100 bg-gray-50 px-3 py-2.5">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $product->product_stock > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-600' }}">
                                    {{ $product->product_stock > 0 ? 'Available' : 'Out of stock' }}
                                </span>
                                <p class="text-xs text-gray-500">{{ $product->product_stock }} pcs</p>
                            </div>

                            <div class="grid grid-cols-2 gap-2 border-t border-gray-100 p-3">
                                <a href="{{ route('admin.product.edit', $product->product_id) }}"
                                    class="inline-flex items-center justify-center rounded-md border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <i class="ri-edit-line mr-1.5 text-base"></i>
                                    Edit
                                </a>
                                <form action="{{ route('admin.product.destroy', $product->product_id) }}" method="POST" class="min-w-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex w-full items-center justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-medium text-white hover:bg-red-600"
                                        onclick="return confirm('Delete this product?')">
                                        <i class="ri-delete-bin-line mr-1.5 text-base"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-lg border border-gray-200 bg-white p-6 text-center text-sm text-gray-500">
                            No products available.
                        </div>
                    @endforelse
                </div>

                <div class="mt-6 hidden overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm md:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Product</th>
                                    <th class="px-6 py-3 font-semibold">Category</th>
                                    <th class="px-6 py-3 font-semibold">Price</th>
                                    <th class="px-6 py-3 font-semibold">Stock</th>
                                    <th class="px-6 py-3 font-semibold">Status</th>
                                    <th class="px-6 py-3 text-right font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $product->product_image }}" alt="{{ $product->product_name }}"
                                                    class="h-12 w-12 rounded-md object-cover">
                                                <div class="min-w-0">
                                                    <p class="max-w-xs truncate font-medium text-gray-900">{{ $product->product_name }}</p>
                                                    <p class="text-xs text-gray-400">#{{ $product->product_id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">{{ $product->productType->product_type_name ?? '-' }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">IDR {{ number_format($product->product_price, 0, ',') }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $product->product_stock }} pcs</td>
                                        <td class="px-6 py-4">
                                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $product->product_stock > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-600' }}">
                                                {{ $product->product_stock > 0 ? 'Available' : 'Out of stock' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('admin.product.edit', $product->product_id) }}"
                                                    class="rounded-md border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.product.destroy', $product->product_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="rounded-md bg-red-500 px-3 py-2 text-sm font-medium text-white hover:bg-red-600"
                                                        onclick="return confirm('Delete this product?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">No products available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            </div>
        </main>
    </div>
</body>

</html>
