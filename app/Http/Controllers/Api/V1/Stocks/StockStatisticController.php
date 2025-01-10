<?php

namespace App\Http\Controllers\Api\V1\Stocks;

use App\Http\Controllers\Controller;

use App\Services\statistics\StockStatisticService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Stock Statistics",
 *     description="API Endpoints for Stock Statistics"
 * )
 */
class StockStatisticController extends Controller
{
    public function __construct(
        private readonly StockStatisticService $stockStatisticService,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $uniqueCode = $request->has('unique_code') ? $request->get('unique_code') : null;
        // Appel au service
        $response = $this->stockStatisticService->getStockStatistics($uniqueCode);

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
