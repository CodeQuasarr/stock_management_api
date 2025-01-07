<?php

namespace App\Services\statistics;

use App\Actions\Statistics\Kpis\CalculateInitialQuantityAction;
use App\Http\Resources\Stocks\StockKpisResource;
use App\Models\kpi;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StockEvolutionService
{

    /**
     * Récupération des statistiques de stock
     * @param null $year
     * @return array
     */
    public function getStocksEvolution($year = null): array
    {

        try {
            if (is_null($year)) {
                $year = Carbon::now()->year;
            }
            // Utilisation de Carbon pour gérer les dates
            $currentMonthStart = Carbon::create($year, 1, 1, 0, 0, 0);
            $currentMonthEnd = Carbon::create($year, 12, 31, 23, 59, 59);

            $stock = Stock::find(1);
            $stockMovements = $stock->movements()->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->get();

            // Calculer la quantité actuelle en stock pour chaque produit
            // Initialiser les variables
            $cumulativeStock = 0;
            $labels = [];
            $data = [];

            // Calculer le stock cumulé
            foreach ($stockMovements as $movement) {
                $quantity = $movement->quantity;
                $action = $movement->type; // "in" ou "out"

                // Ajouter ou soustraire selon le type
                if ($action === 'in') {
                    $cumulativeStock += $quantity;
                } elseif ($action === 'out') {
                    $cumulativeStock -= $quantity;
                }

                // Ajouter les données aux tableaux
                $labels[] = $movement->created_at->format('d/m');
                $data[] = $cumulativeStock;
            }
            // Retour en cas de succès
            return [
                'success' => true,
                'data' => [
                    'labels' => $labels,
                    'data' => $data,
                ],
                'message' => 'Statistiques récupérées avec succès.',
                'status' => 200,
            ];

        } catch (\Exception $e) {
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la récupération des statistiques : ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des statistiques.',
                'error' => $e->getMessage(),
                'status' => 500,
            ];
        }
    }
}
