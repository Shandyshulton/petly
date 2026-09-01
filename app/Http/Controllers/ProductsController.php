<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PetType;
use App\Models\Product;
use App\Models\ProductType;
use App\Support\ProductImageService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    public function edit($id)
    {
        $product = Product::with(['productType', 'petType'])->findOrFail($id);

        return view('admin.editproduct', [
            'product' => $product,
            'productTypes' => ProductType::orderBy('product_type_name')->get(),
            'petTypes' => PetType::orderBy('pet_type_name')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_desc' => 'required|string',
            'product_type' => ['required', Rule::exists('product_types', 'product_type_name')],
            'pet_type' => ['required', Rule::exists('pet_types', 'pet_type_name')],
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10000',
            'product_stock' => 'required|integer|min:0',
            'product_rating' => 'required|numeric|min:0|max:10',
            'product_price' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = Product::findOrFail($id);
        $productType = ProductType::where('product_type_name', $request->product_type)->firstOrFail();
        $petType = PetType::where('pet_type_name', $request->pet_type)->firstOrFail();
        $imagePath = $product->product_image;
        $oldImagePath = $product->product_image;

        if ($request->hasFile('product_image')) {
            $imagePath = app(ProductImageService::class)->store($request->file('product_image'), $product->product_image);
        }

        $product->update([
            'product_name' => $request->product_name,
            'product_desc' => $request->product_desc,
            'product_product_type_id' => $productType->product_type_id,
            'pet_pet_types_id' => $petType->pet_type_id,
            'product_image' => $imagePath,
            'product_stock' => $request->product_stock,
            'product_rating' => $request->product_rating,
            'product_price' => $request->product_price,
        ]);

        app(ProductImageService::class)->deleteIfUnused($oldImagePath, $imagePath);

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $imagePath = $product->product_image;

        $product->delete();
        app(ProductImageService::class)->deleteIfUnused($imagePath);

        return back()->with('success', 'Product deleted successfully.');
    }
}
