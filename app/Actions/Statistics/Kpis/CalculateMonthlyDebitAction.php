<?php

namespace App\Actions\Statistics\Kpis;

use App\Models\Product;

class CalculateMonthlyDebitAction
{
    public function execute(Product $product, $monthStart, $monthEnd): float
    {
        return $product->sales()
                ->where('product_id', $product->id)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('quantity') * $product->sale_price;
    }
}
