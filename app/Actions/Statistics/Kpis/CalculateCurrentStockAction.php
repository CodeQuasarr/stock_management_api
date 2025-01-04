<?php

namespace App\Actions\Statistics\Kpis;

use App\Models\Stock;

class CalculateCurrentStockAction
{

    public function execute(Stock $stock, $monthStart, $monthEnd) {
        $stockMovements = $stock
            ->movements()
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->get();

        // Calculer la quantité actuelle en stock pour ce stock
        $currentQuantity = 0;
        foreach ($stockMovements as $movement) {
            if ($movement->type === 'in') {
                $currentQuantity += $movement->quantity;
            } elseif ($movement->type === 'out' || $movement->type === 'adjustment') {
                $currentQuantity -= $movement->quantity;
            }
        }

        return $currentQuantity;

    }
}
