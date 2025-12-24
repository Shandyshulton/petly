<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-full">
    <div class="flex min-h-screen bg-gray-100">

        <!-- SIDEBAR -->
        <div class="w-16 bg-white flex flex-col items-center py-4 shadow-sm">
            <div class="mb-8">
                <img src="{{ asset('img/logopet.png') }}" alt="Petty Logo" class="w-10 h-7">
            </div>

            <div class="flex flex-col items-center gap-8">
                <a href="{{ route('admin.product.index') }}"
                    class="p-2 rounded-lg bg-pink-50 hover:bg-pink-100 transition-colors">
                    <i class="ri-shopping-bag-3-line text-pink-400 text-xl"></i>
                </a>

                <a href="{{ route('admin.order.index') }}" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="ri-shopping-cart-line text-gray-400 text-xl"></i>
                </a>

                <a href="{{ route('admin.user.index') }}" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="ri-group-line text-gray-400 text-xl"></i>
                </a>
            </div>

            <div class="mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="ri-logout-box-r-line text-red-500 text-xl"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="flex-1 px-4 py-8">
            <div class="max-w-3xl mx-auto">

                <!-- HEADER -->
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Add Product</h1>

                    <a href="{{ route('admin.product.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg shadow-sm hover:bg-gray-400 transition">
                        ← Previous
                    </a>
                </div>

                <!-- ERROR -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- FORM -->
                <div class="p-6 bg-white rounded-xl shadow-md">
                    <form action="{{ route('admin.product.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block font-semibold">Nama Product</label>
                            <input type="text" name="product_name" value="{{ old('product_name') }}"
                                class="w-full border rounded p-2" required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold">URL Foto Product</label>
                            <input type="url" name="product_image" value="{{ old('product_image') }}"
                                class="w-full border rounded p-2" required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold">Deskripsi Product</label>
                            <textarea name="product_desc" class="w-full border rounded p-2" rows="4" required>{{ old('product_desc') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold">Tipe Produk</label>
                            <select name="product_type" class="w-full border rounded p-2" required>
                                <option value="">- Pilih -</option>
                                <option value="food">Food</option>
                                <option value="medicine">Medicine</option>
                                <option value="accesories">Accessories</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold">Jenis Hewan</label>
                            <select name="pet_type" class="w-full border rounded p-2" required>
                                <option value="">- Pilih -</option>
                                <option value="dog">Dog</option>
                                <option value="cat">Cat</option>
                                <option value="rabbit">Rabbit</option>
                                <option value="turtle">Turtle</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold">Harga</label>
                            <input type="number" name="product_price" value="{{ old('product_price') }}"
                                class="w-full border rounded p-2" required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold">Stok</label>
                            <input type="number" name="product_stock" value="{{ old('product_stock') }}"
                                class="w-full border rounded p-2" required>
                        </div>

                        <div class="mb-6">
                            <label class="block font-semibold">Rating</label>
                            <input type="number" step="0.1" min="0" max="10" name="product_rating"
                                value="{{ old('product_rating') }}" class="w-full border rounded p-2">
                        </div>

                        <div class="text-right">
                            <button type="submit" class="px-6 py-2 bg-red-400 text-white rounded-lg hover:bg-red-500">
                                Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</body>

</html>
