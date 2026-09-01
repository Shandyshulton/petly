<?php

namespace App\Http\Controllers;

use App\Models\PetType;
use App\Models\Product;
use App\Models\ProductType;
use App\Support\ProductImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AddProductController extends Controller
{
    public function showForm()
    {
        return view('admin.addproduct', [
            'productTypes' => ProductType::orderBy('product_type_name')->get(),
            'petTypes' => PetType::orderBy('pet_type_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_desc' => 'required|string',
            'product_type' => ['required', Rule::exists('product_types', 'product_type_name')],
            'pet_type' => ['required', Rule::exists('pet_types', 'pet_type_name')],
            'product_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10000',
            'product_stock' => 'required|integer|min:0',
            'product_rating' => 'nullable|numeric|min:0|max:10',
            'product_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $productType = ProductType::where('product_type_name', $request->product_type)->firstOrFail();
            $petType = PetType::where('pet_type_name', $request->pet_type)->firstOrFail();
            $imagePath = app(ProductImageService::class)->store($request->file('product_image'));

            Product::create([
                'product_name' => $request->product_name,
                'product_desc' => $request->product_desc,
                'product_product_type_id' => $productType->product_type_id,
                'pet_pet_types_id' => $petType->pet_type_id,
                'product_image' => $imagePath,
                'product_stock' => $request->product_stock,
                'product_rating' => $request->product_rating ?? 0,
                'product_price' => $request->product_price,
            ]);

            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Product added successfully.');
        } catch (\Throwable $e) {
            return back()
                ->with('failed', 'Failed to add product.')
                ->withInput();
        }
    }
}
