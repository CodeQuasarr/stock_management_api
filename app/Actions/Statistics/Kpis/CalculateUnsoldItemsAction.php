<?php

namespace App\Actions\Statistics\Kpis;

use App\Models\Product;

class CalculateUnsoldItemsAction
{
    public function execute(Product $product, $currentQuantity, $monthStart, $monthEnd): float
    {
        return $currentQuantity - $product
                ->sales()
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('quantity');
    }
}
