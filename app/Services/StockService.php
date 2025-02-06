<?php

namespace App\Services;

use App\Http\Resources\Stocks\StockMovementCollection;
use App\Models\Product;
use App\Models\StockMovement;
use App\Responses\ApiResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockService extends BaseService
{
    public function __construct()
    {}

    /**
     * Calcule le nombre de jours en stock pour un produit donné en fonction de son code unique.
     *
     * @param string $productCode Code unique du produit.
     * @return array Réponse formatée incluant le nombre de jours en stock et un message de succès ou d'erreur.
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

            // Calculer le nombre de jours en stock
            $totalSoldLast30Days = $product->sales()
                ->whereBetween('sale_date', [$startDate, $endDate])
                ->sum('quantity');

            // Calculer le taux de vente moyen par jour (sur les 30 derniers jours)
            $averageDailySales = $totalSoldLast30Days / 30;

            // Éviter une division par zéro
            if ($averageDailySales == 0) {
                return ApiResponse::mapResponse($currentStock > 0 ? INF : 0, 'Days in stock have been successfully recovered.', null, 200);
            }
            return ApiResponse::mapResponse($currentStock / $averageDailySales, 'Days in stock have been successfully recovered.', null, 200);
        } catch (Exception $e) {
            Log::error('Erreur lors de la génération des jours en stock : ' . $e->getMessage());
            return ApiResponse::mapResponse(null, 'An error occurred when retrieving days in stock.', $e->getMessage(), 500);
        }
    }

    /**
     * Récupère les mouvements de stock associés à un produit spécifique en fonction de son code unique.
     *
     * @param string $productCode Code unique du produit pour lequel les mouvements de stock doivent être récupérés.
     * @return array Réponse formatée contenant les mouvements de stock ou un message d'erreur.
     */
    public function getProductMovements(string $productCode): array
    {
        try {
            if (!$productCode) {
                throw new Exception('Product code is required');
            }
            // Récupérer le produit
            $product = Product::query()->where('unique_code', $productCode)->first();

            if (!$product) {
                throw new Exception('Product not found');
            }
            // Récupérer les mouvements de stock pour ce produit
            $stockMovement = StockMovement::query()->where('product_id', $product->id)
                ->paginate(5);
            return ApiResponse::mapResponse(new StockMovementCollection($stockMovement), 'Les mouvements de stock ont été récupérés avec succès.', null, 200);
        } catch (Exception $e) {
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la récupération des mouvements de stock : ' . $e->getMessage());
            return ApiResponse::mapResponse(null, 'An error occurred when retrieving goods movements.', $e->getMessage(), 500);
        }
    }


    /**
     * Récupère une liste de produits paginée.
     *
     * @param Request $request Instance de la requête HTTP.
     * @return array Réponse formatée contenant la liste des produits ou un message d'erreur.
     */
    public function get(Request $request): array
    {
        try {
            $products = Product::query()->paginate(10);
            return ApiResponse::mapResponse($products, 'Liste des produits', null, 200);
        } catch (Exception $e) {
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la récupération des produits : ' . $e->getMessage());
            return ApiResponse::mapResponse(null, 'Une erreur est survenue lors de la récupération des produits.', $e->getMessage(), 500);
        }
    }

    /**
     * Récupère un produit spécifique en fonction de son identifiant unique.
     *
     * @param int $id Identifiant unique du produit.
     * @return array Réponse formatée avec le statut et message de succès ou d'erreur.
     */
    public function find(int $id): array
    {
        try {
            $product = Product::query()->find($id);
            if (!$product) {
                throw new Exception('Product not found');
            }
            return ApiResponse::mapResponse($product, 'Product retrieved successfully', null, 200);
        } catch (Exception $e) {
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la récupération du produit : ' . $e->getMessage());
            return ApiResponse::mapResponse(null, 'An error has occurred during product recovery.', $e->getMessage(), 500);
        }
    }

    /**
     * Crée un nouveau produit avec les données fournies.
     *
     * @param Collection $data Données de création du produit.
     * @return array Réponse formatée avec le statut et message de succès ou d'erreur.
     */
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
            return ApiResponse::mapResponse($product->id, 'Product created successfully.', null, 200);
        } catch (Exception $e) {
            // Rollback en cas d'erreur
            DB::rollBack();

            Log::error('Erreur lors de la création du produit : ' . $e->getMessage());
            return ApiResponse::mapResponse(null, 'An error occurred during product creation.', $e->getMessage(), 500);
        }
    }

    /**
     * Met à jour un produit existant avec les données fournies.
     *
     * @param Collection $data Données de mise à jour du produit.
     * @param mixed $id Identifiant unique du produit.
     * @param Model|null $model Instance du modèle, optionnelle.
     * @return array Réponse formatée avec le statut et message de succès ou d'erreur.
     */
    public function update(Collection $data, $id, Model $model = null): array
    {
        // Début de la transaction
        DB::beginTransaction();
        try {
            $product = Product::query()->find($id);

            if (!$product) {
                throw new Exception('Product not found');
            }

            $fields = $this->getModelFields($data, $product);
            if (!$fields->isEmpty()) {
                $success = $product->update($fields->toArray());

                if (!$success) {
                    throw new Exception('Error updating product');
                }
            }
            if($data['movement_quantity']) {
                $batch = null;
                if ($data['movement_type'] === 'out') {
                    $product->sales()->create([
                        'quantity' => $data['movement_quantity'],
                        'sale_date' => Carbon::now(),
                    ]);
                } else {
                    $batch = $product->batches()->create([
                        'quantity' => $data['movement_quantity'],
                        'expiration_date' => Carbon::parse($data['expiration_date']),
                    ]);
                }
                $product->stockMovements()->create([
                    'product_id' => $product->id,
                    'product_batch_id' => $product->batches()->latest()->first()->id,
                    'quantity' => $data['movement_quantity'],
                    'movement_type' => $data['movement_type'],
                    'reason' => $data['movement_reason'],
                    'date' => Carbon::now(),
                    'batch_id' => $product->batches()->latest()->first()->id,
                ]);
            }

            DB::commit();
            return ApiResponse::mapResponse(null, 'Product updated successfully.', null, 200);
        } catch (Exception $e) {
            // Rollback en cas d'erreur
            DB::rollBack();

            Log::error('Erreur lors de la mise à jour du produit : ' . $e->getMessage());
            return ApiResponse::mapResponse(null, 'An error occurred while updating the product.', $e->getMessage(), 500);
        }
    }

    public function delete(int $id): array
    {
        try {
            $product = Product::query()->find($id);
            if (!$product) {
                throw new Exception('Product not found');
            }
            $product->delete();
            return ApiResponse::mapResponse(null, 'Product deleted successfully.', null, 200);
        } catch (Exception $e) {
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la suppression du produit : ' . $e->getMessage());
            return ApiResponse::mapResponse(null, 'An error occurred while deleting the product.', $e->getMessage(), 500);
        }
    }
}
