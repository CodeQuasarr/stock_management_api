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
class SotckStatisticController extends Controller
{
    public function __construct(
        private readonly StockStatisticService $stockStatisticService,
    )
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/stock-statistics",
     *     summary="Get stock statistics",
     *     tags={"Stock Statistics"},
     *     @OA\Parameter(
     *         name="unique_code",
     *         in="query",
     *         description="Unique code of the product",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Statistiques récupérées avec succès."
     *             ),
     *             @OA\Property(
     *                 property="kpis",
     *                 ref="#/components/schemas/StockKpis"
     *             ),
     *             @OA\Property(
     *                 property="stockSelection",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="value", type="string"),
     *                     @OA\Property(property="label", type="string")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="stockEvolution",
     *                 type="object",
     *                 @OA\Property(
     *                     property="labels",
     *                     type="array",
     *                     @OA\Items(type="string")
     *                 ),
     *                 @OA\Property(
     *                     property="datasets",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="label", type="string"),
     *                         @OA\Property(property="data", type="array", @OA\Items(type="integer")),
     *                         @OA\Property(property="borderColor", type="string"),
     *                         @OA\Property(property="tension", type="number")
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 nullable=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Une erreur est survenue lors de la récupération des statistiques."
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Error message"
     *             )
     *         )
     *     )
     * )
     */
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
