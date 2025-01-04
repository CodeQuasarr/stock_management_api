<?php

namespace App\Actions\Statistics\Kpis;

use App\Models\Product;

class CMVCalculatorAction
{
    public function execute(Product $product, $monthStart, $monthEnd): float
    {
        return $product
                ->sales()
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('quantity') * $product->purchase_price;
    }
}
