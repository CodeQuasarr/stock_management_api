<?php

namespace App\Services;

use App\Http\Resources\Stocks\StockMovementCollection;
use App\Models\Product;
use App\Models\StockMovement;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class StockService
{
    /**
     * Calcule les jours en stock pour un produit donné.
     *
     * @param string $productCode
     * @return array
     */
    public function getDaysInStock(string $productCode): array
    {
        try {
            // Récupérer le produit
            $product = Product::query()->where('unique_code', $productCode)->first();

            if (!$product) {
                throw new Exception('Product not found');
            }

            // Calculer le stock actuel
            $totalStock = $product->batches()->sum('quantity');
            $totalSold = $product->sales()->sum('quantity');
            $currentStock = $totalStock - $totalSold;

            // Calculer le taux de vente moyen par jour (sur les 30 derniers jours)
            $startDate = Carbon::now()->subDays(30);
            $endDate = Carbon::now();

            $totalSoldLast30Days = $product->sales()
                ->whereBetween('sale_date', [$startDate, $endDate])
                ->sum('quantity');

            $averageDailySales = $totalSoldLast30Days / 30;

            // Éviter une division par zéro
            if ($averageDailySales == 0) {
                return [
                    'success' => true,
                    'data' => $currentStock > 0 ? INF : 0, // INF signifie que le stock ne diminue pas,
                    'message' => 'Les jours en stock ont été récupérés avec succès.',
                    'status' => 200,
                ];
            }

            return [
                'success' => true,
                'data' => $currentStock / $averageDailySales,
                'message' => 'Les jours en stock ont été récupérés avec succès.',
                'status' => 200,
            ];
        } catch (Exception $e) {
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la génération des jours en stock : ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des jours en stock.',
                'error' => $e->getMessage(),
                'status' => 500,
            ];
        }
    }

    /**
     * Récupère les mouvements d'un produit donné.
     *
     * @param string $productCode
     * @return array
     */
    public function getProductMovements(string $productCode): array
    {
        try {
            // Récupérer le produit
            $product = Product::query()->where('unique_code', $productCode)->first();

            if (!$product) {
                throw new Exception('Product not found');
            }

            // Récupérer les mouvements de stock pour ce produit
            $stockMovement = StockMovement::query()->where('product_id', $product->id)
                ->paginate(5);

            return [
                'success' => true,
                'data' => new StockMovementCollection($stockMovement) ?? [],
                'message' => 'Les mouvements de stock ont été récupérés avec succès.',
                'status' => 200,
            ];
        } catch (Exception $e) {
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la récupération des mouvements de stock : ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des mouvements de stock.',
                'error' => $e->getMessage(),
                'status' => 500,
            ];
        }
    }
}
