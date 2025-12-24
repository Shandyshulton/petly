<?php

namespace App\Http\Resources;

use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'product_desc' => $this->product_desc,
            'product_type' => new ProductTypeResource($this->whenLoaded('productType')),
            'pet_type' => new PetTypeResource($this->whenLoaded('petType')),
            'product_image' => $this->product_image,
            'product_stock' => $this->product_stock,
            'product_rating' => $this->product_rating,
            'product_price' => $this->product_price,
        ];
    }
}
