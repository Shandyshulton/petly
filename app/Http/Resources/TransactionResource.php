<?php

namespace App\Http\Resources;

use App\Models\TransactionDetail;
use App\Models\TransactionStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'transaction_id' => $this->transaction_id,
            'user' => new UserResource($this->whenLoaded('users')),
            'cart' => new CartResource($this->whenLoaded('cart')),
            'delivery' => new DeliveryResource($this->whenLoaded('delivery')),
            'transaction_status' => new TransactionStatusResource($this->whenLoaded('transactionStatus')),
            'transaction_details' => new TransactionDetailResource($this->whenLoaded('transactionDetails')),
            'transaction_date' => $this->transaction_date,
        ];
    }
}
