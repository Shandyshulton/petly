<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DeliveryClass;
use App\Models\PaymentMethod;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:Credit Card,COD,QRIS,VA Bank',
            'delivery_class' => 'required|in:standard,express',
            'transaction_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Accept a single transaction_id or an array of transaction_ids.
        $transactionIds = is_array($request->transaction_id) ? $request->transaction_id : [$request->transaction_id];

        $userCustomer = null;
        foreach ($transactionIds as $transactionId) {
            $transaction = Transaction::where('transaction_id', $transactionId)->first();
            if ($transaction == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Transaction Not Found',
                ], 422);
            } else if ($transaction->transactions_transaction_status_id == 2) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment is Completed',
                ], 422);
            }
            $userCustomer = Customer::where('user_user_id', $transaction->user_user_id)->first();
            if (!$userCustomer->address) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please input your address first',
                ], 422);
            }
        }

        DB::beginTransaction();

        try {
            $paymentMethod = PaymentMethod::where('payment_method_name', $request->payment_method)->first();
            if (!$paymentMethod) {
                $paymentMethod = PaymentMethod::create([
                    'payment_method_id' => ((int) PaymentMethod::max('payment_method_id')) + 1,
                    'payment_method_name' => $request->payment_method,
                ]);
            }
            $deliveryClass = DeliveryClass::where('delivery_class_name', $request->delivery_class)->first();

            $payments = [];
            $deliveries = [];

            foreach ($transactionIds as $transactionId) {
                $transaction = Transaction::where('transaction_id', $transactionId)->first();
                $userCustomer = Customer::where('user_user_id', $transaction->user_user_id)->first();

                $payment = Payment::create([
                    'payment_payment_method_id' => $paymentMethod->payment_method_id,
                    'payment_transaction_id' => $transaction->transaction_id,
                ]);

                if ($request->delivery_class == 'standard') {
                    $delivery_deadline = Carbon::parse($payment->created_at)->addDays(4);
                } else {
                    $delivery_deadline = Carbon::parse($payment->created_at)->addDays(2);
                }

                $delivery = Delivery::create([
                    'delivery_address' => $userCustomer->address,
                    'courier_id' => null,
                    'delivery_deadline' => $delivery_deadline,
                    'delivery_delivery_class_id' => $deliveryClass->delivery_class_id
                ]);

                $transaction->update([
                    'transactions_transaction_status_id' => 2,
                    'delivery_delivery_id' => $delivery->delivery_id
                ]);

                $cart = Cart::where('cart_id', $transaction->foreign_cart_id)->first();
                $product = Product::where('product_id', $cart->foreign_product_id)->first();

                $product->update([
                    'product_stock' => $product->product_stock - $cart->quantity
                ]);

                Cart::where('cart_id', $transaction->foreign_cart_id)->delete();

                $payments[] = $payment;
                $deliveries[] = $delivery;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment successfully',
                'data' => [
                    'payment_method' => $paymentMethod,
                    'transactions' => Transaction::whereIn('transaction_id', $transactionIds)->get(),
                    'deliveries' => $deliveries,
                ],
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Input Payment Failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }
}
