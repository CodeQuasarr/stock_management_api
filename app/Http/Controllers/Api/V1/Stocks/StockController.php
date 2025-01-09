<?php

namespace App\Http\Controllers\Api\V1\Stocks;

use App\Http\Controllers\Controller;
use App\Http\Resources\Stocks\StockCollection;
use App\Http\Resources\Stocks\StockResource;
use App\Models\Product;
use App\Services\StockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{

    public function __construct(private readonly StockService $stockService) { }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): StockCollection|JsonResponse
    {
        $response = $this->stockService->get($request);

        if (array_key_exists('data', $response)) {
            return new StockCollection($response['data']);
        } else {
            return response()->json([
                'success' => $response['success'] ?? null,
                'message' => $response['message'] ?? null,
                'error' => $response['error'] ?? null,
            ], $response['status']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $response = $this->stockService->create( collect($request->all()));

        return response()->json([
            'success' => $response['success'],
            'data' => $response['data'] ?? null,
            'message' => $response['message'],
            'error' => $response['error'] ?? null,
        ], $response['status']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): StockResource|JsonResponse
    {
        $response = $this->stockService->find($id);

        if ($response['success']) {
            return new StockResource($response['data']);
        } else {
            return response()->json([
                'success' => $response['success'] ?? null,
                'message' => $response['message'] ?? null,
                'error' => $response['error'] ?? null,
            ], $response['status']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $response = $this->stockService->update( collect($request->all()), $id);

        return response()->json([
            'success' => $response['success'] ?? null,
            'message' => $response['message'] ?? null,
            'error' => $response['error'] ?? null,
        ], $response['status']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $response = $this->stockService->delete($id);

        return response()->json([
            'success' => $response['success'] ?? null,
            'message' => $response['message'] ?? null,
            'error' => $response['error'] ?? null,
        ], $response['status']);
    }

    /**
     * Récupère les jours en stock pour un produit donné.
     *
     * @param string $productCode
     * @return JsonResponse
     */
    public function getDaysInStock(string $productCode): JsonResponse
    {
        $response = $this->stockService->getDaysInStock($productCode);

        // Retour de la réponse structurée
        return response()->json([
            'success' => $response['success'] ?? null,
            'message' => $response['message'] ?? null,
            'days_in_stock' => $response['data'] ?? null,
            'error' => $response['error'] ?? null,
        ], $response['status']);
    }

    /**
     * Récupère les mouvements d'un produit donné.
     *
     * @param string $productCode
     * @return JsonResponse
     */
    public function getProductMovements(string $productCode): JsonResponse
    {
        $response = $this->stockService->getProductMovements($productCode);
        // Retour de la réponse structurée
        return response()->json([
            'success' => $response['success'] ?? null,
            'message' => $response['message'] ?? null,
            'stock_movements' => $response['data'] ?? null,
            'error' => $response['error'] ?? null,
        ], $response['status']);
    }
}
