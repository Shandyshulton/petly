<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductCartController extends Controller
{
    public function store(Request $request)
    {
        $apiToken = session('api_token');
        $customerID = session('user_id');
        Http::withToken($apiToken)
            ->post('http://petly.test:8080/api/customer/cart', [
                'customer_user_id' => $customerID,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

        return back()->with('success', 'Input Cart Successful');
    }

//     public function store(Request $request)
// {
//     $apiToken = session('api_token');
//     $customerID = session('user_id');
//     $productId = $request->product_id;
//     $requestedQuantity = $request->quantity;

//     try {
//         // First, check the product stock
//         $productResponse = Http::withToken($apiToken)
//             ->get("http://petly.test:8080/api/products/{$productId}");

//         if (!$productResponse->successful()) {
//             return back()->with('error', 'Unable to verify product availability. Please try again.');
//         }

//         $productData = $productResponse->json('data');
//         $availableStock = $productData['product_stock'];

//         // Check if product is out of stock
//         if ($availableStock <= 0) {
//             return back()->with('error', 'This product is currently out of stock.');
//         }

//         // Check if requested quantity exceeds available stock
//         if ($requestedQuantity > $availableStock) {
//             return back()->with('error', "Only {$availableStock} items available in stock. Please reduce the quantity.");
//         }

//         // If stock validation passes, add to cart
//         $cartResponse = Http::withToken($apiToken)
//             ->post('http://petly.test:8080/api/customer/cart', [
//                 'customer_user_id' => $customerID,
//                 'product_id' => $productId,
//                 'quantity' => $requestedQuantity,
//             ]);

//         if ($cartResponse->successful()) {
//             return back()->with('success', 'Item added to cart successfully!');
//         } else {
//             return back()->with('error', 'Failed to add item to cart. Please try again.');
//         }

//     } catch (\Exception $e) {
//         return back()->with('error', 'An error occurred. Please try again later.');
//     }
// }
}



