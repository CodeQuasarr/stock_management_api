<?php

namespace App\Http\Controllers\Api\V1\Stocks;

use App\Http\Controllers\Controller;
use App\Services\statitics\StockEvolutionService;
use App\Services\statitics\StockStatisticService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SotckStatisticController extends Controller
{
    public function __construct(
        private readonly StockStatisticService $stockStatisticService,
        private readonly StockEvolutionService $stockEvolutionService
    )
    {
    }

    /**
     * Récupération des statistiques de stock
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $productId = $request->has('product_id') ? $request->get('product_id') : null;
        // Appel au service
        $response = $this->stockStatisticService->getStockStatistics($productId);

        // Retour de la réponse structurée
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'kpis' => $response['data'] ?? null,
            'stockSelection' => $response['stockItems'] ?? null,
            'stockEvolution' => $response['stockEvolution'] ?? null,
            'error' => $response['error'] ?? null,
        ], $response['status']);
    }
}
