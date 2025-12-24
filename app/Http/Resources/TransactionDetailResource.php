<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_payment' => $this->total_payment,
            'quantity' => $this->quantity,
            'product' => new ProductResource($this->whenLoaded('product'))
        ];
    }
}
