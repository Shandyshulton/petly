<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pet_id' => $this->pet_id,
            'pet_name' => $this->pet_name,
            'pet_gender' => $this->pet_gender,
            'pet_weight' => $this->pet_weight,
            'customer' => new UserResource($this->whenLoaded('customerDetails')),
            'pet_type' => new PetTypeResource($this->whenLoaded('petTypeDetails'))
        ];
    }
}
