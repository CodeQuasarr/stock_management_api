<?php

namespace App\Services\statitics;

use App\Http\Resources\Stocks\StockKpisResource;
use App\Models\kpi;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StockStatisticService
{

    /**
     * Récupération des statistiques de stock
     * @return array
     */
    public function getStockStatistics(?int $stockId = null): array
    {
        try {
            $stockItems = $this->getStockCategoryForUser();
            $currentStock = Stock::find($stockId ?? $stockItems[0]['value']);
            $stockStatistic = $this->generateKpis($currentStock);
            $stockEvolution = $this->getStockEvolutionForUser($currentStock);

            // Retour en cas de succès
            return [
                'success' => true,
                'data' => $stockStatistic ? new StockKpisResource($stockStatistic) : null,
                'stockItems' => $stockItems,
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
     * @throws \Exception
     */
    /**
     * @throws \Exception
     */
    /**
     * @throws \Exception
     */
    public function getStockCategoryForUser()
    {
        $seller = User::find(8);
        if (!$seller) {
            throw new \Exception("Utilisateur non trouvé.");
        }

        $stockModel = $seller->stocks();
        if (!$stockModel) {
            throw new \Exception("Aucun stock trouvé pour cet utilisateur.");
        }

        $stockItems = $stockModel->get()->map(function ($stock) {
            if (!$stock->product) {
                throw new \Exception("Produit non trouvé pour le stock.");
            }
            return [
                'value' => $stock->product->getKey(),
                'label' => $stock->product->name,
            ];
        });

        return $stockItems;
    }

    public function generateKpis(Stock $stock)
    {
        // Récupération du statistique de stock
        return kpi::query()->where('stock_id', $stock->getKey())->latest()->first();
    }

    public function getStockEvolutionForUser(Stock $stock, string $year = null) {
        if (is_null($year)) {
            $year = Carbon::now()->year;
        }
        // Utilisation de Carbon pour gérer les dates
        $currentMonthStart = Carbon::create($year, 1, 1, 0, 0, 0);
        $currentMonthEnd = Carbon::create($year, 12, 31, 23, 59, 59);
        $stockMovements = $stock->movements()->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->get();

        // Calculer la quantité actuelle en stock pour chaque produit
        // Initialiser les variables
        $cumulativeStock = 0;
        $labels = [];
        $data = [];

        // Calculer le stock cumulé
        foreach ($stockMovements as $index => $movement) {
            $quantity = $movement->quantity;
            $action = $movement->type; // "in" ou "out"

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
