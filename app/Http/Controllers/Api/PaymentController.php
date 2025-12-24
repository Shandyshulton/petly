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
            'payment_method' => 'required|in:Credit Card,COD',
            'delivery_class' => 'required|in:standard,express',
            'transaction_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $transaction = Transaction::where('transaction_id', $request->transaction_id)->first();
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

        DB::beginTransaction();
        
        try {
            $userCustomer = Customer::where('user_user_id', $transaction->user_user_id)->first();
            if (!$transaction) {
                return response()->json([
                    'status' => false,
                    'message' => 'No transaction with this id',
                ], 422);
            }
            if (!$userCustomer->address) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please input your address first',
                ], 422);
            }
            $transactionDetail = TransactionDetail::where('transaction_transaction_id', $request->transaction_id)->first();
            $paymentMethod = PaymentMethod::where('payment_method_name', $request->payment_method)->first();
            
            $deliveryClass = DeliveryClass::where('delivery_class_name', $request->delivery_class)->first();

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

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment successfully',
                'data' => [
                    'payment_method' => $paymentMethod,
                    'transaction' => $transaction,
                    'transaction_detail' => $transactionDetail,
                    'product' => $product,
                    'delivery' => $delivery
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
