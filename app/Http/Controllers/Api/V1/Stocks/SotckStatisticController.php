<?php

namespace App\Http\Controllers\Api\V1\Stocks;

use App\Http\Controllers\Controller;
use App\Services\StockStatisticService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SotckStatisticController extends Controller
{
    public function __construct( private readonly StockStatisticService $stockStatisticService ) {}

    /**
     * Récupération des statistiques de stock
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Appel au service
        $response = $this->stockStatisticService->getStockStatistics();

        // Retour de la réponse structurée
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'kpis' => $response['data'] ?? null,
            'stockSelection' => $response['stockItems'] ?? null,
            'error' => $response['error'] ?? null,
        ], $response['status']);
    }
}
