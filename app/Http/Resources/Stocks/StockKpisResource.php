<?php

namespace App\Http\Resources\Stocks;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @OA\Schema(
 *     schema="StockKpis",
 *     type="object",
 *     title="Stock KPIs",
 *     description="Stock Key Performance Indicators",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the KPI"
 *     ),
 *     @OA\Property(
 *         property="product_id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the product"
 *     ),
 *     @OA\Property(
 *         property="stock_level",
 *         type="integer",
 *         description="Current stock level"
 *     ),
 *     @OA\Property(
 *         property="stock_value",
 *         type="number",
 *         format="float",
 *         description="Total value of the stock"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation date of the KPI"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update date of the KPI"
 *     )
 * )
 */
class StockKpisResource extends JsonResource
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
