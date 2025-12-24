<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'delivery_class_name' => $this->delivery_class_name,
            'delivery_class_price' => $this->delivery_class_price,
            'delivery_class_desc' => $this->delivery_class_desc,
        ];
    }
}
