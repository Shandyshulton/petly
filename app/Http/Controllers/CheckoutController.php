<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function storeCheckout(Request $request)
    {
        $apiToken = session('api_token');
        $customerID = session('user_id');

        if (!$apiToken || !$customerID) {
            return redirect()->route('login');
        }

        $selectedItem = $request->input('selected_item');

        $response = Http::withToken($apiToken)->post(
            'http://petly.test:8080/api/customer/transaction',
            [
                'user_id' => $customerID,
                'status_name' => 'pending',
                'cart_id' => $selectedItem,
                'transaction_date' => Carbon::now()->toDateTimeString(),
            ]
        );

        if (!$response->successful()) {
            return redirect()->route('cart.index')
                ->with('failed', 'Gagal membuat transaksi.');
        }

        $data = $response->json('data');

        // simpan 1x saja
        Session::put('checkout_data', $data);
        Session::put('shipping_fee', 15000);
        Session::put('payment_method', 'credit_card');

        return redirect()->route('checkout.index');
    }

    public function showCheckout()
    {
        $checkoutData = Session::get('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('cart.index');
        }

        $shippingFee = session('shipping_fee', 15000);
        $paymentMethod = session('payment_method', 'credit_card');
        $taxAmount = 25000;

        $total = $checkoutData['cart']['total_price'] + $shippingFee + $taxAmount;

        return view('checkout', [
            'transactionId' => $checkoutData['transaction']['transaction_id'],
            'subtotal'      => $checkoutData['cart']['total_price'],
            'product'       => $checkoutData['product'],
            'cart'          => $checkoutData['cart'],
            'user'          => $checkoutData['user'],
            'userDetail'    => $checkoutData['user_detail'],
            'shippingFee'   => $shippingFee,
            'paymentMethod'=> $paymentMethod,
            'taxAmount'     => $taxAmount,
            'total'         => $total,
        ]);
    }

    public function updateShipping(Request $request)
    {
        Session::put('shipping_fee', (int) $request->shipping_fee);
        return redirect()->route('checkout.index');
    }

    public function updatePaymentMethod(Request $request)
    {
        Session::put('payment_method', $request->payment_method);
        return redirect()->route('checkout.index');
    }

    public function storePayment(Request $request)
    {
        $apiToken = session('api_token');
        $checkoutData = Session::get('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('cart.index');
        }

        if (empty($checkoutData['user_detail']['address'])) {
            return redirect()->route('checkout.index')
                ->with('failed', 'Alamat belum diisi.');
        }

        $response = Http::withToken($apiToken)->post(
            'http://petly.test:8080/api/customer/payment',
            [
                'payment_method' => $request->payment_method === 'cod' ? 'COD' : 'Credit Card',
                'delivery_class' => 'standard',
                'transaction_id' => $request->transaction_id,
            ]
        );

        if (!$response->successful()) {
            return redirect()->route('checkout.index')
                ->with('failed', 'Pembayaran gagal.');
        }

        // bersihkan session checkout
        Session::forget(['checkout_data', 'shipping_fee', 'payment_method']);

        return redirect()->route('history')
            ->with('success', 'Order berhasil dibuat dan pembayaran diproses.');
    }

    public function finish(Request $request)
    {
        $apiToken = session('api_token');

        Http::withToken($apiToken)->post(
            'http://petly.test:8080/api/customer/transaction-update',
            [
                'transaction_id' => $request->transaction_id,
                'status_name' => 'canceled',
            ]
        );

        Session::forget(['checkout_data', 'shipping_fee', 'payment_method']);

        return redirect()->route('history')
            ->with('success', 'Order berhasil dibatalkan.');
    }
}
