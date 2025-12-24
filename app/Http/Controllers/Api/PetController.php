<?php

namespace App\Http\Controllers\Api;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PetResource;
use App\Http\Controllers\Controller;
use App\Models\PetType;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Pet::with(['customerDetails', 'petTypeDetails'])->get();
        if ($product) {
            return PetResource::collection($product);
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
            'pet_name' => 'required|string|max:255',
            'pet_gender' => 'required|in:male,female',
            'pet_weight' => 'required|integer',
            'pet_type' => 'required|in:dog,rabbit,cat,turtle',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        $petType = PetType::where('pet_type_name', $request->pet_type)->first();
        try {


            $pet = Pet::firstOrCreate([
                'pet_name' => $request->pet_name,
                'pet_gender' => $request->pet_gender,
                'pet_weight' => $request->pet_weight,
                'user_user_id' => $request->user()->user_id,
                'pet_pet_types_id' => $petType->pet_type_id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Pet successfully added ',
                'data' => [
                    'pet_name' => $pet->pet_name,
                    'pet_gender' => $pet->pet_gender,
                    'pet_weight' => $pet->pet_weight,
                    'customer' => $request->user()->username,
                    'pet_pet_types_id' => $petType->pet_type_name,
                ],
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $petType->pet_type_id,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $pet = Pet::where('customer_details_user_user_id', $user->customerDetails->user_user_id)
            ->where('pet_id', $id)
            ->firstOrFail();

        return response()->json($pet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();

        return response()->json([
            'status' => true,
            'message' => 'Successfully Deleted Pet'
        ]);
    }
}
