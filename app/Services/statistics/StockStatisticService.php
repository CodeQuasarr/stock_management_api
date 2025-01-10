<?php

namespace App\Services\statistics;

use App\Http\Resources\Stocks\StockKpisResource;
use App\Models\kpi;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\Sale;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StockStatisticService
{

    /**
     * Récupération des statistiques de stock
     * @param string|null $uniqueCode
     * @return array
     */
    public function getStockStatistics(?string $uniqueCode = null): array
    {
        try {
            $stockItems = Product::query()->get()->map(function ($product) {
                return [
                    'value' => $product->unique_code,
                    'label' => $product->name,
                ];
            });

            $product = Product::query()->where('unique_code', $uniqueCode ?? $stockItems[0]['value']);
            $stockStatistic = $this->generateKpis($product->first());
            $stockEvolution = $this->getStockEvolutionForUser($product->first());

            // Retour en cas de succès
            return [
                'success' => true,
                'data' => $stockStatistic ? new StockKpisResource($stockStatistic) : null,
                'stockItems' => $stockItems->toArray(),
                'stockEvolution' => $stockEvolution,
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

    /**
     * Génère les KPIs pour un produit donné
     * @param Product $product
     * @return kpi|null
     */
    public function generateKpis(Product $product): ?kpi
    {
        // Récupération de la statistique de stock
        return kpi::query()->where('product_id', $product->getKey())->latest()->first();
    }

    /**
     * Récupère l'évolution des stocks pour un produit donné
     * @param Product $product
     * @param string|null $year
     * @return array
     */
    public function getStockEvolutionForUser(Product $product, string $year = null): array
    {
        if (is_null($year)) {
            $year = Carbon::now()->year;
        }
        // Utilisation de Carbon pour gérer les dates
        $currentMonthStart = Carbon::create($year, 1, 1, 0, 0, 0);
        $currentMonthEnd = Carbon::create($year, 12, 31, 23, 59, 59);
        $stockMovements = $product->stockMovements()->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->get();

        // Calculer la quantité actuelle en stock pour chaque produit
        // Initialiser les variables
        $cumulativeStock = 0;
        $labels = [];
        $data = [];

        // Calculer le stock cumulé
        foreach ($stockMovements as $index => $movement) {
            $quantity = $movement->quantity;
            $action = $movement->type;

            if ($index === 0 && $action === 'out') {
                $movement = StockMovement::find($movement->getKey() - 1);
                while ($movement->type === 'out') {
                    $quantity += $movement->quantity;
                    $movement = StockMovement::find($movement->getKey() - 1);
                }
                $cumulativeStock = $movement->quantity - $quantity;
            } elseif ($action === 'in') {
                $cumulativeStock += $quantity;
            } elseif ($action === 'out') {
                $cumulativeStock -= $quantity;
            }

            // Ajouter les données aux tableaux
            $labels[] = $movement->created_at->format('d/m');
            $data[] = $cumulativeStock;
        }

        return [
            'labels' => $labels,
            'datasets' => [[
                'label' => 'Évolution des stocks',
                'data' => $data,
                'borderColor' => '#2563EB',
                'tension' => 0.4,
            ]]
        ];
    }

    /**
     * Récupère la valeur totale du stock pour un produit donné
     * @param string $productCode
     * @return float|int
     */
    public function getTotalStockValue(string $productCode)
    {
        $product = Product::query()->where('unique_code', $productCode)->first();
        return $product->batches->sum(function ($batch) use ($product) {
            return $batch->quantity * $product->purchase_price;
        });
    }

    /**
     * Récupère L'évolution de la valeur du stock pour un produit donné par rapport au mois précédent
     * @param string $productCode
     * @return array
     */
    public function getStockValueEvolution(string $productCode): float|int
    {
        $product = Product::query()->where('unique_code', $productCode)->first();

        $currentMonthValue = $product->batches()
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('quantity') * $product->purchase_price;

        $previousMonthValue = $product->batches()
                ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->sum('quantity') * $product->purchase_price;

        return ($currentMonthValue - $previousMonthValue) / $previousMonthValue * 100;
    }

    /**
     * Récupère la rotation des stocks pour un produit donné ce mois-ci
     * @param string $productCode
     * @return float|int
     */
    public function getStockTurnover(string $productCode): float|int
    {
        $product = Product::query()->where('unique_code', $productCode)->first();

        // Quantité vendue ce mois-ci
        $soldQuantity = $product->sales()
            ->whereMonth('sale_date', Carbon::now()->month)
            ->sum('quantity');

        // Quantité moyenne en stock ce mois-ci
        $averageStock = $product->batches()
            ->whereMonth('created_at', Carbon::now()->month)
            ->avg('quantity');

        if ($averageStock == 0) {
            return 0;
        }

        return ($soldQuantity / $averageStock) * 100;
    }

    /**
     * Récupère l'évolution de la rotation des stocks pour un produit donné par rapport au mois précédent
     * @param string $productCode
     * @return float|int
     */
    public function getStockTurnoverEvolution(string $productCode): float|int
    {
        $currentMonthTurnover = $this->getStockTurnover($productCode);

        // Calculer la rotation du mois précédent
        $product = Product::query()->where('unique_code', $productCode)->first();

        $previousMonthSoldQuantity = $product->sales()
            ->whereMonth('sale_date', Carbon::now()->subMonth()->month)
            ->sum('quantity');

        $previousMonthAverageStock = $product->batches()
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->avg('quantity');

        if ($previousMonthAverageStock == 0) {
            return 0;
        }

        $previousMonthTurnover = ($previousMonthSoldQuantity / $previousMonthAverageStock) * 100;

        // Calculer l'évolution
        return ($currentMonthTurnover - $previousMonthTurnover) / $previousMonthTurnover * 100;
    }

    /**
     * Récupère le nombre de jours en stock pour un produit donné
     * @param string $productCode
     * @return float|int
     */
    public function getUnsoldItems(string $productCode): float|int
    {
        $product = Product::query()->where('unique_code', $productCode)->first();

        // Quantité totale en stock
        $totalStock = $product->batches()->sum('quantity');

        // Quantité vendue
        $soldQuantity = $product->sales()->sum('quantity');

        return $totalStock - $soldQuantity;
    }

    /**
     * Récupère l'évolution du nombre d'articles invendus pour un produit donné par rapport au mois précédent
     * @param string $productCode
     * @return float|int
     */
    public function getUnsoldItemsEvolution(string $productCode): float|int
    {
        $product = Product::query()->where('unique_code', $productCode)->first();

        // Articles invendus ce mois-ci
        $currentMonthUnsold = $this->getUnsoldItems($productCode);

        // Articles invendus le mois dernier
        $previousMonthStock = $product->batches()
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('quantity');

        $previousMonthSold = $product->sales()
            ->whereMonth('sale_date', Carbon::now()->subMonth()->month)
            ->sum('quantity');

        $previousMonthUnsold = $previousMonthStock - $previousMonthSold;

        if ($previousMonthUnsold == 0) {
            return 0;
        }

        return ($currentMonthUnsold - $previousMonthUnsold) / $previousMonthUnsold * 100;
    }

    /**
     * Récupère le nombre de jours en stock pour un produit donné
     * @param string $productCode
     * @return float|int
     */
    public function getMonthlyDebit(string $productCode): array
    {
        $product = Product::query()->where('unique_code', $productCode)->first();

        // Récupérer les ventes mensuelles
        $monthlySales = Sale::where('product_id', $product->id)
            ->selectRaw('DATE_FORMAT(sale_date, "%Y-%m") as month, SUM(quantity) as sold_quantity')
            ->groupBy('month')
            ->get();

        // Récupérer le stock initial mensuel
        $monthlyStock = ProductBatch::where('product_id', $product->id)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(quantity) as initial_stock')
            ->groupBy('month')
            ->get();

        // Calculer le monthly debit
        $monthlyDebit = [];
        foreach ($monthlySales as $sale) {
            $stock = $monthlyStock->where('month', $sale->month)->first();
            if ($stock && $stock->initial_stock > 0) {
                $monthlyDebit[$sale->month] = ($sale->sold_quantity / $stock->initial_stock) * 100;
            } else {
                $monthlyDebit[$sale->month] = 0;
            }
        }

        return $monthlyDebit;
    }

    /**
     * Calcule les KPIs pour un produit donné
     * @param Product $product
     * @param kpi|null $lastKpi
     * @param StockMovement[] $stockMovements
     * @param Sale[] $sales
     * @param ProductBatch[] $batches
     * @param Product[] $products
     * @return kpi[]
     */
    public function calculateKpis(Product $product, ?kpi $lastKpi, array $stockMovements, array $sales, array $batches, array $products): array {
        $kpis = [];
        $currentKpi = new kpi();
        $currentKpi->product_id = $product->getKey();
        $currentKpi->stock_id = $product->stock_id;
        $currentKpi->stock_value = $this->getTotalStockValue($product->unique_code);
        $currentKpi->stock_value_evolution = $this->getStockValueEvolution($product->unique_code);
        $currentKpi->stock_turnover = $this->getStockTurnover($product->unique_code);
        $currentKpi->stock_turnover_evolution = $this->getStockTurnoverEvolution($product->unique_code);
        $currentKpi->unsold_items = $this->getUnsoldItems($product->unique_code);
        $currentKpi->unsold_items_evolution = $this->getUnsoldItemsEvolution($product->unique_code);
        $currentKpi->monthly_debit = $this->getMonthlyDebit($product->unique_code);
        $currentKpi->created_at = Carbon::now();
        $currentKpi->updated_at = Carbon::now();
        $kpis[] = $currentKpi;

        return $kpis;
    }
}
