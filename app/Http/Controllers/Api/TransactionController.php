<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\TransactionDetail;
use App\Models\TransactionStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TransactionResource;
use App\Models\Cart;
use App\Models\Customer;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('sanctum')->user();
        $transaction = Transaction::with(['users', 'cart.product', 'transactionStatus', 'transactionDetails.product.productType', 'transactionDetails.product.petType'])
            ->where('user_user_id', $user->user_id)
            ->get();
        if ($transaction) {
            return TransactionResource::collection($transaction);
        } else {
            return response()->json(['message' => 'No Record Available'], 200);
        }
    }

    public function indexWithStatusProgress()
    {
        $transaction = Transaction::with(['users', 'cart.product', 'transactionStatus', 'transactionDetails.product.productType', 'transactionDetails.product.petType'])
            ->where('transactions_transaction_status_id', 2)
            ->get();
        if ($transaction) {
            return TransactionResource::collection($transaction);
        } else {
            return response()->json(['message' => 'No Record Available'], 200);
        }
    }

    public function indexAll()
    {
        $transaction = Transaction::with(['users', 'cart.product', 'transactionStatus', 'transactionDetails.product.productType', 'transactionDetails.product.petType'])->get();
        if ($transaction) {
            return TransactionResource::collection($transaction);
        } else {
            return response()->json(['message' => 'No Record Available'], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'status_name' => 'required|in:complete,progress,pending,canceled',
            'cart_id' => 'required|integer',
            'transaction_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // $checkCart = Transaction::where('foreign_cart_id', $request->cart_id)->first();
        // if ($checkCart) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Your cart already in transaction',
        //     ]);
        // }

        DB::beginTransaction();
        try {

            $transactionStatus = TransactionStatus::where('transaction_status_name', $request->status_name)->first();

            $transaction = Transaction::create([
                'transaction_date' => $request->transaction_date,
                'user_user_id' => $request->user_id,
                'foreign_cart_id' => $request->cart_id,
                'delivery_delivery_id' => null,
                'transactions_transaction_status_id' => $transactionStatus->transaction_status_id,
            ]);

            $totalPayment = 0;
            $cart = Cart::where('cart_id', $request->cart_id)->first();
            $totalPayment += $cart->total_price;

            $transactionDetail = TransactionDetail::create([
                'transaction_transaction_id' => $transaction->transaction_id,
                'foreign_product_id' => $cart->foreign_product_id,
                'quantity' => $cart->quantity,
                'total_payment' => $totalPayment + 25000,
            ]);
            $user = User::where('user_id', $transaction->user_user_id)->first();
            $product = Product::where('product_id', $cart->foreign_product_id)->first();
            $userCustomer = Customer::where('user_user_id', $transaction->user_user_id)->first();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Transaction successfully added',
                'data' => [
                    'transaction' => $transaction,
                    'user' => $user,
                    'user_detail' => $userCustomer,
                    'transaction_status' => $transactionStatus,
                    'transaction_detail' => $transactionDetail,
                    'cart' => $cart,
                    'product' => $product
                ],
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
        $product = Transaction::with(['users', 'delivery.deliveryClass', 'cart.product', 'transactionStatus', 'transactionDetails.product.productType', 'transactionDetails.product.petType'])
        ->where('transaction_id', $id)
        ->first();
        if ($product) {
            return new TransactionResource($product);
        } else {
            return response()->json(['message' => 'No Record Available'], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|integer',
            'status_name' => 'required|in:complete,progress,pending,canceled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $transaction = Transaction::where('transaction_id', $request->transaction_id)->first();

        $transactionStatus = 0;
        if ($request->status_name == 'complete') {
            $transactionStatus = 1;
        }elseif ($request->status_name == 'progress') {
            $transactionStatus = 2;
        }elseif ($request->status_name == 'pending') {
            $transactionStatus = 3;
        }else{
            $transactionStatus = 4;
        }

        $transaction->update([
            'transactions_transaction_status_id' => $transactionStatus
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Transaction successfully update',
            'data' => [
                'transaction' => $transaction,
            ],
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
