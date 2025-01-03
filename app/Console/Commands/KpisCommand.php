<?php

namespace App\Console\Commands;

use App\Models\kpi;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class KpisCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:kpis-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Dates pour le mois actuel
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        // Dates pour le mois dernier
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Récupérer les mouvements de stock pour le mois actuel
        $stockMovements = StockMovement::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->get();
        // Calculer la quantité actuelle en stock pour chaque produit
        $currentStock = [];
        foreach ($stockMovements as $movement) {
            $productId = $movement->stock->product_id;
            if (!isset($currentStock[$productId])) {
                $currentStock[$productId] = 0;
            }
            if ($movement->type === 'in') {
                $currentStock[$productId] += $movement->quantity;
            } elseif ($movement->type === 'out' || $movement->type === 'adjustment') {
                $currentStock[$productId] -= $movement->quantity;
            }
        }

        // Calculer la valeur du stock actuel
        $currentStockValue = 0;
        foreach ($currentStock as $productId => $quantity) {
            $product = Product::find($productId);
            $currentStockValue += $quantity * $product->purchase_price;
        }
        // Calculer le coût des marchandises vendues (CMV) pour le mois actuel
        $currentCMV = Sale::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->with('product')
            ->get()
            ->sum(function ($sale) {
                return $sale->quantity * $sale->product->purchase_price;
            });

        // Calculer le stock moyen pour le mois actuel
        $initialStockValue = StockMovement::where('created_at', '<', $currentMonthStart)
            ->get()
            ->groupBy('stock.product_id')
            ->map(function ($movements, $productId) {
                $quantity = 0;
                foreach ($movements as $movement) {
                    if ($movement->type === 'in') {
                        $quantity += $movement->quantity;
                    } elseif ($movement->type === 'out' || $movement->type === 'adjustment') {
                        $quantity -= $movement->quantity;
                    }
                }
                $product = Product::find($productId);
                return $quantity * $product->purchase_price;
            })
            ->sum();

        $averageStock = ($initialStockValue + $currentStockValue) / 2;

        // Calculer la rotation des stocks pour le mois actuel
        $currentStockRotation = $averageStock > 0 ? ($currentCMV / $averageStock) : 0;

        // Calculer les articles invendus pour le mois actuel
        $currentUnsoldItems = array_sum($currentStock) - Sale::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->sum('quantity');

        // Calculer le débit mensuel pour le mois actuel
        $currentMonthlyDebit = Sale::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->with('product')
            ->get()
            ->sum(function ($sale) {
                return $sale->quantity * $sale->product->sale_price;
            });

        // Récupérer les KPI du mois dernier
        $lastKpi = Kpi::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->first();

        // Calculer les changements en pourcentage
        $changeStockValue = $lastKpi ? (($currentStockValue - $lastKpi->stock_value) / $lastKpi->stock_value) * 100 : 0;
        $changeStockRotation = $lastKpi ? (($currentStockRotation - $lastKpi->stock_rotation) / $lastKpi->stock_rotation) * 100 : 0;
        $changeUnsoldItems = $lastKpi ? (($currentUnsoldItems - $lastKpi->unsold_items) / $lastKpi->unsold_items) * 100 : 0;
        $changeMonthlyDebit = $lastKpi ? (($currentMonthlyDebit - $lastKpi->monthly_debit) / $lastKpi->monthly_debit) * 100 : 0;

        // Enregistrer les KPI dans la base de données
        Kpi::create([
            'stock_value' => $currentStockValue,
            'change_stock_value' => $changeStockValue,
            'stock_rotation' => $currentStockRotation,
            'change_stock_rotation' => $changeStockRotation,
            'unsold_items' => $currentUnsoldItems,
            'change_unsold_items' => $changeUnsoldItems,
            'monthly_debit' => $currentMonthlyDebit,
            'change_monthly_debit' => $changeMonthlyDebit,
        ]);

        $this->info('KPIs calculated and saved successfully!');
    }
}
