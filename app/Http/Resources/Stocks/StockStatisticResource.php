<?php

namespace App\Http\Resources\Stocks;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockStatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'stock_value' => $this->stock_value,
            'change_stock_value' => $this->change_stock_value,
            'stock_rotation' => $this->stock_rotation,
            'change_stock_rotation' => $this->change_stock_rotation,
            'unsold_items' => $this->unsold_items,
            'change_unsold_items' => $this->change_unsold_items,
            'monthly_flow_rate' => $this->monthly_debit,
            'change_monthly_flow_rate' => $this->change_monthly_debit,
        ];
    }
}
