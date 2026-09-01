<?php

namespace App\Http\Controllers;

use App\Models\PetType;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['productType', 'petType'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('product_name', 'like', "%{$search}%")
                        ->orWhere('product_id', $search)
                        ->orWhereHas('productType', fn ($query) => $query->where('product_type_name', 'like', "%{$search}%"))
                        ->orWhereHas('petType', fn ($query) => $query->where('pet_type_name', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('product_type'), fn ($query) => $query->where('product_product_type_id', $request->integer('product_type')))
            ->when($request->filled('pet_type'), fn ($query) => $query->where('pet_pet_types_id', $request->integer('pet_type')))
            ->when($request->filled('stock'), function ($query) use ($request) {
                if ($request->stock === 'available') {
                    $query->where('product_stock', '>', 0);
                }

                if ($request->stock === 'out') {
                    $query->where('product_stock', '<=', 0);
                }
            })
            ->latest('product_id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.product', [
            'products' => $products,
            'productTypes' => ProductType::orderBy('product_type_name')->get(),
            'petTypes' => PetType::orderBy('pet_type_name')->get(),
            'filters' => $request->only(['q', 'product_type', 'pet_type', 'stock']),
        ]);
    }
}
