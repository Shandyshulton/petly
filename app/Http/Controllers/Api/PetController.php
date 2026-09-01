<?php

namespace App\Http\Controllers\Api;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PetResource;
use App\Http\Controllers\Controller;
use App\Models\PetType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'pet_weight' => 'required|integer|min:0',
            'pet_type' => ['required', Rule::exists('pet_types', 'pet_type_name')],
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
            $petType = PetType::where('pet_type_name', $request->pet_type)->firstOrFail();

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
                'message' => 'Failed to add pet',
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
        $pet = Pet::where('user_user_id', $user->user_id)
            ->where('pet_id', $id)
            ->firstOrFail();

        return response()->json($pet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        if ($pet->user_user_id !== $request->user()->user_id) {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'pet_name' => 'required|string|max:255',
            'pet_gender' => 'required|in:male,female',
            'pet_weight' => 'required|integer|min:0',
            'pet_type' => ['required', Rule::exists('pet_types', 'pet_type_name')],
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
            $petType = PetType::where('pet_type_name', $request->pet_type)->firstOrFail();

            $pet->update([
                'pet_name' => $request->pet_name,
                'pet_gender' => $request->pet_gender,
                'pet_weight' => $request->pet_weight,
                'pet_pet_types_id' => $petType->pet_type_id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Pet successfully updated',
                'data' => new PetResource($pet->load(['customerDetails', 'petTypeDetails'])),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to update pet',
                'error' => $e->getMessage()
            ], 500);
        }
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
