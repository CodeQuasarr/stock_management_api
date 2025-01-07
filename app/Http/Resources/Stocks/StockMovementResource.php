<?php

namespace App\Http\Resources\Stocks;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockMovementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'unique_code' => $this->product->unique_code,
            ],
            'type' => $this->type,
            'reason' => $this->reason,
            'expiration_date' => $this->batch->expiration_date,
            'quantity' => $this->batch->quantity,
        ];
    }
}
