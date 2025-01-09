<?php

namespace App\Http\Controllers\Api\V1\Stocks;

use App\Http\Controllers\Controller;
use App\Http\Resources\Stocks\StockCollection;
use App\Http\Resources\Stocks\StockResource;
use App\Responses\ApiResponse;
use App\Services\StockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0.0",
 *     description="Documentation for the API endpoints",
 *     @OA\Contact(
 *         email="support@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api/v1",
 *     description="Local development server"
 * )
 */
class StockController extends Controller
{

    public function __construct(private readonly StockService $stockService) { }


    /**
     * @OA\Get(
     *     path="/stocks",
     *     summary="List all stocks",
     *     tags={"Stocks"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function index(Request $request): StockCollection|JsonResponse
    {
        $response = $this->stockService->get($request);
        if (array_key_exists('data', $response)) {
            return new StockCollection($response['data']);
        }
        return ApiResponse::sendResponse($response['data'], $response['message'], $response['error'] ?? null, $response['status']);
    }

    /**
     * @OA\Post(
     *     path="/stocks",
     *     summary="Create a new stock",
     *     tags={"Stocks"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product data to create",
     *         @OA\JsonContent(
     *             required={"name", "unique_code", "description", "purchase_price", "expiration_date", "sale_price", "stock_quantity", "therapeutic_category", "manufacturer"},
     *             @OA\Property(property="name", type="string", example="Product"),
     *             @OA\Property(property="unique_code", type="string", example="PROD123"),
     *             @OA\Property(property="description", type="string", example="A product description"),
     *             @OA\Property(property="purchase_price", type="number", format="float", example=10.99),
     *             @OA\Property(property="expiration_date", type="string", example="2023-12-31"),
     *             @OA\Property(property="sale_price", type="number", format="float", example=19.99),
     *             @OA\Property(property="stock_quantity", type="integer", example=100),
     *             @OA\Property(property="therapeutic_category", type="string", example="Category"),
     *             @OA\Property(property="manufacturer", type="string", example="Manufacturer XYZ")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Product created successfully."),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An error occurred while creating the product."),
     *             @OA\Property(property="error", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $response = $this->stockService->create( collect($request->all()));
        return ApiResponse::sendResponse($response['data'] ?? null, $response['message'], $response['error'] ?? null, $response['status']);
    }

    /**
     * @OA\Get(
     *     path="/stocks/{id}",
     *     summary="Get a specific stock",
     *     tags={"Stocks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the stock",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Stock not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function show(string $id): StockResource|JsonResponse
    {
        $response = $this->stockService->find($id);
        if ($response['success']) {
            return ApiResponse::sendResponse(new StockResource($response['data']), $response['message'], $response['error'] ?? null, $response['status']);
        }
        return ApiResponse::sendResponse(null, $response['message'], $response['error'] ?? null, $response['status']);
    }

    /**
     * @OA\Put(
     *     path="/stocks/{id}",
     *     summary="Update a product in stock",
     *     tags={"Stocks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product data to update",
     *         @OA\JsonContent(
     *             required={"name", "unique_code", "description", "sale_price", "stock_quantity", "therapeutic_category", "manufacturer"},
     *             @OA\Property(property="name", type="string", example="OMEPRAZOLE"),
     *             @OA\Property(property="unique_code", type="string", example="PROD123"),
     *             @OA\Property(property="description", type="string", example="A product description"),
     *             @OA\Property(property="sale_price", type="number", format="float", example=19.99),
     *             @OA\Property(property="stock_quantity", type="integer", example=100),
     *             @OA\Property(property="therapeutic_category", type="string", example="Category A"),
     *             @OA\Property(property="manufacturer", type="string", example="Manufacturer XYZ")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Product updated successfully."),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Product not found."),
     *             @OA\Property(property="error", type="string", example="Product not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An error occurred while updating the product."),
     *             @OA\Property(property="error", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $response = $this->stockService->update( collect($request->all()), $id);
        return ApiResponse::sendResponse(null, $response['message'], $response['error'] ?? null, $response['status']);

    }

    /**
     * @OA\Delete(
     *     path="/stocks/{id}",
     *     summary="Delete a specific stock",
     *     tags={"Stocks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the stock",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Stock deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Stock not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        $response = $this->stockService->delete($id);
        return ApiResponse::sendResponse(null, $response['message'], $response['error'] ?? null, $response['status']);
    }

    /**
     * @OA\Get(
     *     path="/stocks/{productCode}/days-in-stock",
     *     summary="Get days in stock for a specific product",
     *     tags={"Stocks"},
     *     @OA\Parameter(
     *         name="productCode",
     *         in="path",
     *         required=true,
     *         description="Unique code of the product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="number",
     *                 format="float"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function getDaysInStock(string $productCode): JsonResponse
    {
        $response = $this->stockService->getDaysInStock($productCode);
        return ApiResponse::sendResponse($response['data'], $response['message'], $response['error'] ?? null, $response['status']);
    }

    /**
     * @OA\Get(
     *     path="/stocks/{productCode}/movements",
     *     summary="Get stock movements for a specific product",
     *     tags={"Stocks"},
     *     @OA\Parameter(
     *         name="productCode",
     *         in="path",
     *         required=true,
     *         description="Unique code of the product",
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
     *                 example="Stock movements retrieved successfully."
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/StockMovement")
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 nullable=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
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
     *                 example="Product not found."
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Product not found"
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
     *                 example="An error occurred while retrieving stock movements."
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
    public function getProductMovements(string $productCode): JsonResponse
    {
        $response = $this->stockService->getProductMovements($productCode);
        return ApiResponse::sendResponse($response['data'] ?? null, $response['message'], $response['error'] ?? null, $response['status']);
    }
}
