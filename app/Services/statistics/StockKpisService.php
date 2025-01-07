<?php

namespace App\Services\statistics;

use App\Http\Resources\Stocks\StockKpisResource;
use App\Models\kpi;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class StockKpisService
{

    /**
     * Récupération des statistiques de stock
     * @param int|null $stockId
     * @return array
     */
    public function getStockStatistics(?int $stockId = null): array
    {

        try {
            $seller = User::find(10);
            $stockModel = $seller->stocks();
            $stockItems = $stockModel->get()->map(function ($stock) {
                return [
                    'value' => $stock->product->getKey(),
                    'label' => $stock->product->name,
                ];
            });
            if (!is_null($stockId)) {
                $stock = $stockModel->where("id", $stockId)->first();
            } else {
                $stock = $stockModel->first();
            }

            // Récupération du statistique de stock
            $stockStatistic = kpi::query()->where('stock_id', $stock->id)->latest()->first();
            // Retour en cas de succès
            return [
                'success' => true,
                'data' => $stockStatistic ? new StockKpisResource($stockStatistic) : null,
                'stockItems' => $stockItems,
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
