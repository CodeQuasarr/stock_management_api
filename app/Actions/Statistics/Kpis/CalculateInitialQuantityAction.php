<?php

namespace App\Actions\Statistics\Kpis;

use App\Models\Stock;

class CalculateInitialQuantityAction
{
    public function execute(Stock $stock, $monthStart): float
    {
        return $stock->movements()
            ->where('created_at', '<', $monthStart)
            ->get()
            ->sum(function ($movement) {
                if ($movement->type === 'in') {
                    return $movement->quantity;
                } elseif ($movement->type === 'out' || $movement->type === 'adjustment') {
                    return -$movement->quantity;
                }
                return 0;
            });
    }
}
