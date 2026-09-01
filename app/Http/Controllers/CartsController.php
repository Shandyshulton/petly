<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CartsController extends Controller
{

    public function index(Request $request)
    {
        if (!session()->has('api_token')) {
            return redirect()
                ->route('login')
                ->with('failed', 'Please login first to view your cart.');
        }

        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)
            ->get(config('services.petly_api.url') . '/api/customer/cart');

        // Initialize values
        $items = [];
        $selectedTotal = 0;
        $tax = 0;
        $total = 0;
        $selectedCartId = $request->input('selected_item');

        if ($response->successful()) {
            $items = $response->json('data') ?? [];

            if ($selectedCartId) {
                foreach ($items as $item) {
                    if ($item['cart_id'] == $selectedCartId) {
                        $selectedTotal = floatval($item['total_price']);
                        break;
                    }
                }
                $tax = 25000;
                $total = $selectedTotal + $tax;
            }
        }
        return view('cart', compact('items', 'selectedTotal', 'tax', 'total', 'selectedCartId'));
    }

    public function destroy($id)
    {
        if (!session()->has('api_token')) {
            return redirect()
                ->route('login')
                ->with('failed', 'Please login first to manage your cart.');
        }

        $apiToken = session('api_token');
        Http::withToken($apiToken)
            ->delete(config('services.petly_api.url') . "/api/customer/cart/{$id}");

        return redirect()->route('cart.index');
    }
}
