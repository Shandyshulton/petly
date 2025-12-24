<?php

namespace App\Http\Controllers\Api;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryResource;
use App\Models\Courier;
use App\Models\DeliveryClass;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $delivery = Delivery::with(['deliveryClass', 'user', 'courier', 'transaction.transactionStatus'])->get();
        if ($delivery) {
            return DeliveryResource::collection($delivery);
        } else {
            return response()->json(['message' => 'No Record Available'], 200);
        }
    }

    public function indexCourierNow()
    {
        $user = auth('sanctum')->user();
        $delivery = Delivery::with(['deliveryClass', 'user', 'courier', 'transaction.transactionStatus', 'transaction.transactionDetails.product.productType', 'transaction.users'])->where('courier_id', $user->user_id)->get();
        if ($delivery) {
            return DeliveryResource::collection($delivery);
        } else {
            return response()->json(['message' => 'No Record Available'], 200);
        }
    }

    public function indexGetCourierNull()
    {
        $delivery = Delivery::with(['deliveryClass', 'user', 'courier', 'transaction.transactionStatus'])->where('courier_id', null)->get();
        if ($delivery) {
            return DeliveryResource::collection($delivery);
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
            'delivery_address' => 'required|string|max:255',
            'courier_id' => 'required|integer',
            'delivery_deadline' => 'required|date',
            'delivery_class' => 'required|in:standard,express'
        ]);

        $courier = Courier::where('user_user_id', $request->courier_id)->first();

        if ($validator->fails() && !$courier) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {

            
            $deliveryClass = DeliveryClass::where('delivery_class_name', $request->delivery_class)->first();

            $delivery = Delivery::create([
                'delivery_address' => $request->delivery_address,
                'courier_id' => $courier->user_user_id,
                'delivery_deadline' => $request->delivery_deadline,
                'delivery_delivery_class_id' => $deliveryClass->delivery_class_id
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Delivery successfully create',
                'data' => [
                    'delivery_address' => $delivery->delivery_address,
                    'courier' => $request->courier_id,
                    'delivery_deadline' => $delivery->delivery_deadline,
                    'delivery_class' => $deliveryClass->delivery_class_name
                ],
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Input Delivery failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Delivery $delivery)
    {
        $validator = Validator::make($request->all(), [
            'courier_id' => 'required|integer',
            'delivery_id' => 'required|integer'
        ]);

        $courier = Courier::where('user_user_id', $request->courier_id)->first();

        if ($validator->fails() && !$courier) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $delivery = Delivery::where('delivery_id', $request->delivery_id)->first();

        $delivery->update([
            'courier_id' => $request->courier_id
        ]);

        $transaction = Transaction::where('delivery_delivery_id', $request->delivery_id)->first();
        $transaction->update([
            'transactions_transaction_status_id' => 1
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Delivery update successfull',
            'data' => [
                'delivery' => $delivery,
                'courier' => $request->courier_id,
                'transaction' => $transaction,
            ],
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        //
    }
}
