<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
</head>


<body class="h-full">
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-16 bg-white flex flex-col items-center py-4 shadow-sm">
            <div class="mb-8">
                <img src="/img/logopet.png" alt="Petty Logo" class="w-10 h-7">
            </div>
            <div class="flex flex-col items-center gap-8">
                {{-- <a href="/admin/dashboard" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="ri-pie-chart-line text-gray-400 text-xl"></i>
                </a> --}}
                <a href="/admin/product" class="p-2 rounded-lg bg-pink-50 hover:bg-pink-100 transition-colors">
                    <i class="ri-shopping-bag-3-line text-pink-400  text-xl"></i>
                </a>
                <a href="/admin/order" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="ri-shopping-cart-line text-gray-400 text-xl"></i>
                </a>
                <a href="/admin/user" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="ri-group-line text-gray-400 text-xl"></i>
                </a>
            </div>
            <div class="mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="cursor-pointer p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="ri-logout-box-r-line text-red-500 text-xl"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="mx-auto mt-10 bg-gray-100 min-h-screen">
            <div class="flex items-center justify-between mb-5">
                <div class="relative w-1/3">
                    <input type="text" placeholder="Search"
                        class="w-full border rounded-lg p-3 pl-10 shadow-sm focus:ring-2 focus:ring-gray-300">
                    <svg class="absolute left-3 top-3 text-gray-400 w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M10 17a7 7 0 1 1 0-14 7 7 0 0 1 0 14z" />
                    </svg>
                </div>
                <div class="flex items-center space-x-3">
                    {{-- <button class="flex items-center px-4 py-2 bg-gray-200 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 mr-1 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        Filter
                    </button> --}}
                    <a href="{{ route('admin.product.add') }}"
                        class="px-4 py-2 bg-red-400 text-white rounded-lg shadow-sm hover:bg-red-500">
                        Add New Product
                    </a>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-5">Product Management Dashboard</h2>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="pr-10 pl-6 py-3 text-gray-600">Product Name</th>
                            <th class="pr-10 pl-6 py-3 text-gray-600">Product ID</th>
                            <th class="pr-10 pl-6 py-3 text-gray-600">Price</th>
                            <th class="pr-10 pl-6 py-3 text-gray-600">Stock</th>
                            <th class="pr-10 pl-8 py-3 text-gray-600">Status</th>
                            <th class="pr-10 pl-10 py-3 text-gray-600">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products['data'] as $product)
                            <tr class="border-b last:border-b-0 hover:bg-gray-100">
                                <td class="px-6 py-4">{{ $product['product_name'] }}</td>
                                <td class="px-6 py-4">#{{ $product['product_id'] }}</td>
                                <td class="px-6 py-4">IDR {{ $product['product_price'] }}</td>
                                <td class="px-6 py-4">{{ $product['product_stock'] }} pcs</td>
                                <td
                                    class="px-6 py-4 font-semibold {{ $product['product_stock'] > 0 ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $product['product_stock'] > 0 ? 'Available' : 'Out of Stock' }}
                                </td>
                                <td class="px-8 py-4">
                                    <form action="{{ route('products.destroy', $product['product_id']) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded-md"
                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
