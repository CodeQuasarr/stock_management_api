<?php

namespace App\Http\Resources\Stocks;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sale_price' => $this->sale_price,
            'description' => $this->description,
            'unique_code' => $this->unique_code,
            'manufacturer' => $this->manufacturer,
            'therapeutic_category' => $this->therapeutic_category,
            'stock_quantity' => $this->stockTotals(),
        ];
    }
}
