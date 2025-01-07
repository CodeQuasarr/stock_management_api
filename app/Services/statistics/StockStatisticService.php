<?php

namespace App\Services\statistics;

use App\Http\Resources\Stocks\StockKpisResource;
use App\Models\kpi;
use App\Models\Product;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StockStatisticService
{

    /**
     * Récupération des statistiques de stock
     * @param string|null $uniqueCode
     * @return array
     */
    public function getStockStatistics(?string $uniqueCode = null): array
    {
        try {
            $stockItems = Product::query()->get()->map(function ($product) {
                return [
                    'value' => $product->unique_code,
                    'label' => $product->name,
                ];
            });

            $product = Product::query()->where('unique_code', $uniqueCode ?? $stockItems[0]['value']);
            $stockStatistic = $this->generateKpis($product->first());
            $stockEvolution = $this->getStockEvolutionForUser($product->first());

            // Retour en cas de succès
            return [
                'success' => true,
                'data' => $stockStatistic ? new StockKpisResource($stockStatistic) : null,
                'stockItems' => $stockItems->toArray(),
                'stockEvolution' => $stockEvolution,
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

    /**
     * Génère les KPIs pour un produit donné
     * @param Product $product
     * @return kpi|null
     */
    public function generateKpis(Product $product): ?kpi
    {
        // Récupération de la statistique de stock
        return kpi::query()->where('product_id', $product->getKey())->latest()->first();
    }

    /**
     * Récupère l'évolution des stocks pour un produit donné
     * @param Product $product
     * @param string|null $year
     * @return array
     */
    public function getStockEvolutionForUser(Product $product, string $year = null): array
    {
        if (is_null($year)) {
            $year = Carbon::now()->year;
        }
        // Utilisation de Carbon pour gérer les dates
        $currentMonthStart = Carbon::create($year, 1, 1, 0, 0, 0);
        $currentMonthEnd = Carbon::create($year, 12, 31, 23, 59, 59);
        $stockMovements = $product->stockMovements()->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->get();

        // Calculer la quantité actuelle en stock pour chaque produit
        // Initialiser les variables
        $cumulativeStock = 0;
        $labels = [];
        $data = [];

        // Calculer le stock cumulé
        foreach ($stockMovements as $index => $movement) {
            $quantity = $movement->quantity;
            $action = $movement->type;

            if ($index === 0 && $action === 'out') {
                $movement = StockMovement::find($movement->getKey() - 1);
                while ($movement->type === 'out') {
                    $quantity += $movement->quantity;
                    $movement = StockMovement::find($movement->getKey() - 1);
                }
                $cumulativeStock = $movement->quantity - $quantity;
            } elseif ($action === 'in') {
                $cumulativeStock += $quantity;
            } elseif ($action === 'out') {
                $cumulativeStock -= $quantity;
            }

            // Ajouter les données aux tableaux
            $labels[] = $movement->created_at->format('d/m');
            $data[] = $cumulativeStock;
        }

        return [
            'labels' => $labels,
            'datasets' => [[
                'label' => 'Évolution des stocks',
                'data' => $data,
                'borderColor' => '#2563EB',
                'tension' => 0.4,
            ]]
        ];
    }
}
