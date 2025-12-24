<?php

namespace App\Http\Controllers\Api;

use App\Models\PetType;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Filter\ProductFilter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProductPaginateResource;

class ProductController extends Controller
{

    public function successResponse($data = null, $code = Response::HTTP_OK)
    {
         return response()->json($data, $code);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::with(['productType', 'petType'])->get();
        if ($product) {
            return ProductResource::collection($product);
        } else {
            return response()->json(['message' => 'No Record Available'], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_desc' => 'required|string|max:255',
            'product_type' => 'required|in:food,medicine,accesories',
            'pet_type' => 'required|in:dog,rabbit,cat,turtle',
            'transaction_id' => 'nullable',
            'product_image' => 'required|string|max:255',
            'product_stock' => 'required|integer',
            'product_rating' => 'required|integer|between:1,10',
            'product_price' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $productType = ProductType::where('product_type_name', $request->product_type)->first();
            $petType = PetType::where('pet_type_name', $request->pet_type)->first();


            $product = Product::create([
                'product_name' => $request->product_name,
                'product_desc' => $request->product_desc,
                'product_product_type_id' => $productType->product_type_id,
                'pet_pet_types_id' => $petType->pet_type_id,
                'product_image' => $request->product_image,
                'product_stock' => $request->product_stock,
                'product_rating' => $request->product_rating,
                'product_price' => $request->product_price
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Product successfully added',
                'data' => $product,
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Input Product failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['productType', 'petType'])->findOrFail($id);

        if ($product) {
            return new ProductResource($product);
        } else {
            return response()->json(['message' => 'No Record Available'], 200);
        }
    }


    /**
     * Update the specifixed resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Successfully Deleted Product'
        ]);
    }
}
