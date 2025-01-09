<?php

namespace App\Services;

use App\Http\Resources\Stocks\StockMovementCollection;
use App\Models\Product;
use App\Models\StockMovement;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockService extends BaseService
{
    public function __construct()
    {
        $model = new Product();
        parent::__construct($model);
    }

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

    public function get(Request $request): array
    {
        try {
            $products = Product::query()->paginate(3);
            return [
                'data' => $products,
            ];
        } catch (Exception $e) {
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la récupération des produits : ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des produits.',
                'error' => $e->getMessage(),
                'status' => 500,
            ];
        }
    }

    public function find(int $id): array
    {
        try {
            $product = Product::query()->find($id);

            if (!$product) {
                throw new Exception('Product not found');
            }

            return [
                'success' => true,
                'data' => $product,
                'message' => 'Product retrieved successfully.',
                'status' => 200,
            ];
        } catch (Exception $e) {
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la récupération du produit : ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération du produit.',
                'error' => $e->getMessage(),
                'status' => 500,
            ];
        }
    }

    public function create(Collection $data): array
    {
        // Début de la transaction
        DB::beginTransaction();
        try {
            $product = new Product();
            $fields = $this->getModelFields($data, $product);
            $product = $product->create($fields->toArray());

            if (!$product) {
                throw new Exception('Error creating product');
            }

            $batch = $product->batches()->create([
                'quantity' => $data['stock_quantity'],
                'expiration_date' => Carbon::parse($data['expiration_date']),
            ]);

            if (!$batch) {
                throw new Exception('Error creating batch');
            }

            $product->stockMovements()->create([
                'product_id' => $product->id,
                'quantity' => $data['stock_quantity'],
                'movement_type' => 'IN',
                'reason' => 'Entrée de stock',
                'date' => Carbon::now(),
                'batch_id' => $batch->id,
            ]);

            // Commit de la transaction si tout s'est bien passé
            DB::commit();
            return [
                'success' => true,
                'data' => $product->id,
                'message' => 'Product created successfully.',
                'status' => 200,
            ];
        } catch (Exception $e) {
            // Rollback en cas d'erreur
            DB::rollBack();
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la création du produit : ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création du produit.',
                'error' => $e->getMessage(),
                'status' => 500,
            ];
        }
    }

    public function update(Collection $data, $id, Model $model = null): array
    {
        // Début de la transaction
        DB::beginTransaction();
        try {
            $product = Product::query()->find($id);

            if (!$product) {
                throw new Exception('Product not found');
            }

            $product->update($data->toArray());
            $fields = $this->getModelFields($data, $product);
            $success = $product->update($fields->toArray());

            if (!$success) {
                throw new Exception('Error updating product');
            }

            if ($data['stock_quantity'] !== $product->stockTotals()) {
                $batch = $product->batches();
                if ($data['stock_quantity'] - $product->stockTotals()) {
                    $product->stockMovements()->create([
                        'quantity' => $data['stock_quantity'] - $product->stockTotals(),
                        'movement_type' => 'IN',
                        'reason' => 'Entrée de stock',
                        'date' => Carbon::now(),
                        'batch_id' => $batch->latest()->first()->id,
                    ]);
                } else {
                    $product->stockMovements()->create([
                        'quantity' => $product->stockTotals() - $data['stock_quantity'],
                        'movement_type' => 'OUT',
                        'reason' => 'Vente',
                        'date' => Carbon::now(),
                        'batch_id' => $batch->latest()->first()->id,
                    ]);
                }
            }
            // Commit de la transaction si tout s'est bien passé
            DB::commit();
            return [
                'success' => true,
                'message' => 'Product updated successfully.',
                'status' => 200,
            ];
        } catch (Exception $e) {
            // Rollback en cas d'erreur
            DB::rollBack();
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la mise à jour du produit : ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du produit.',
                'error' => $e->getMessage(),
                'status' => 500,
            ];
        }
    }

    public static function new()
    {
        // TODO: Implement new() method.
    }

    public function attach(Collection $data, Model $model, $relation = null): JsonResponse
    {
        // TODO: Implement attach() method.
    }

    public function delete(int $id): array
    {
        try {
            $product = Product::query()->find($id);

            if (!$product) {
                throw new Exception('Product not found');
            }

            $product->delete();

            return [
                'success' => true,
                'message' => 'Product deleted successfully.',
                'status' => 200,
            ];
        } catch (Exception $e) {
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la suppression du produit : ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression du produit.',
                'error' => $e->getMessage(),
                'status' => 500,
            ];
        }
    }
}
