<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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

        <main class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl">
                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-medium text-pink-500">Product</p>
                        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Add Product</h1>
                    </div>

                    <a href="{{ route('admin.product.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                        <i class="ri-arrow-left-line mr-2 text-lg"></i>
                        Back
                    </a>
                </div>

                <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
                    @csrf

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="sm:col-span-2">
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Product Name</span>
                            <input type="text" name="product_name" value="{{ old('product_name') }}"
                                class="w-full rounded-lg border border-gray-200 p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20" required>
                        </label>

                        <label class="sm:col-span-2">
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Product Image</span>
                            <div class="flex items-center gap-4">
                                <img id="image-preview" src="{{ asset('img/logo-petly.png') }}" alt="Preview"
                                    class="h-24 w-24 shrink-0 rounded-lg border border-gray-200 object-cover">
                                <div class="flex-1">
                                    <input type="file" name="product_image" id="product_image" accept="image/jpeg,image/png,image/webp"
                                        class="block w-full text-sm text-gray-500 file:mr-3 file:rounded-lg file:border-0 file:bg-[#FE9494] file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-[#FE7A7A]" required>
                                    <p class="mt-1.5 text-xs text-gray-400">JPG, PNG, or WebP. Images larger than 3MB are automatically resized.</p>
                                </div>
                            </div>
                            @error('product_image')
                                <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="sm:col-span-2">
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Description</span>
                            <textarea name="product_desc" rows="4"
                                class="w-full resize-y rounded-lg border border-gray-200 p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20" required>{{ old('product_desc') }}</textarea>
                        </label>

                        <label>
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Product Type</span>
                            <select name="product_type"
                                class="w-full rounded-lg border border-gray-200 p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20" required>
                                <option value="">Select product type</option>
                                @foreach ($productTypes as $type)
                                    <option value="{{ $type->product_type_name }}" @selected(old('product_type') === $type->product_type_name)>
                                        {{ ucfirst($type->product_type_name) }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label>
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Pet Type</span>
                            <select name="pet_type"
                                class="w-full rounded-lg border border-gray-200 p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20" required>
                                <option value="">Select pet type</option>
                                @foreach ($petTypes as $type)
                                    <option value="{{ $type->pet_type_name }}" @selected(old('pet_type') === $type->pet_type_name)>
                                        {{ ucfirst($type->pet_type_name) }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label>
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Price</span>
                            <input type="text" inputmode="numeric" name="product_price" id="product_price" value="{{ old('product_price') }}" placeholder="0"
                                class="w-full rounded-lg border border-gray-200 p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20" required>
                        </label>

                        <label>
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Stock</span>
                            <input type="number" min="0" name="product_stock" value="{{ old('product_stock') }}"
                                class="w-full rounded-lg border border-gray-200 p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20" required>
                        </label>

                        <label class="sm:col-span-2">
                            <span class="mb-1 block text-sm font-semibold text-gray-700">Rating</span>
                            <input type="number" step="0.1" min="0" max="10" name="product_rating"
                                value="{{ old('product_rating', 0) }}"
                                class="w-full rounded-lg border border-gray-200 p-3 text-sm outline-none focus:border-[#FE9494] focus:ring-2 focus:ring-[#FE9494]/20" required>
                        </label>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-[#FE9494] px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#FE7A7A] sm:w-auto">
                            Save Product
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        const imageInput = document.getElementById('product_image');
        const imagePreview = document.getElementById('image-preview');
        const priceInput = document.getElementById('product_price');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                imagePreview.src = URL.createObjectURL(file);
            }
        });

        priceInput.addEventListener('input', function () {
            let digits = this.value.replace(/\D/g, '');
            this.value = digits ? Number(digits).toLocaleString('en-US') : '';
        });

        // Strip commas before submitting so the server receives a plain number.
        priceInput.form.addEventListener('submit', function () {
            priceInput.value = priceInput.value.replace(/\D/g, '');
        });
    </script>
</body>

</html>
