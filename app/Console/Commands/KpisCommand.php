<?php

namespace App\Console\Commands;

use App\Models\kpi;
use App\Models\Product;
use App\Models\ProductBatch;
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
        $products = Product::all();

        $products->each(function ($product) {
            kpi::create([
                'product_id' => $product->getKey(),
                'stock_value' => $this->getTotalStockValue($product->unique_code),
                'change_stock_value' => $this->getStockValueEvolution($product->unique_code),
                'stock_rotation' => $this->getStockTurnover($product->unique_code),
                'change_stock_rotation' => $this->getStockTurnoverEvolution($product->unique_code),
                'unsold_items' => $this->getUnsoldItems($product->unique_code),
                'change_unsold_items' => $this->getUnsoldItemsEvolution($product->unique_code),
            ]);

            $this->info('KPIs have been generated successfully.' . $product->name);
        });
    }

    public function getTotalStockValue($productCode)
    {
        $product = Product::where('unique_code', $productCode)->first();
        return $product->batches->sum(function ($batch) use ($product) {
            return $batch->quantity * $product->purchase_price;
        });
    }

    public function getStockValueEvolution($productCode)
    {
        $product = Product::where('unique_code', $productCode)->first();

        $currentMonthValue = $product->batches()
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('quantity') * $product->purchase_price;

        $previousMonthValue = $product->batches()
                ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->sum('quantity') * $product->purchase_price;

        return ($currentMonthValue - $previousMonthValue) / $previousMonthValue * 100;
    }

    public function getStockTurnover($productCode)
    {
        $product = Product::where('unique_code', $productCode)->first();

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

    public function getStockTurnoverEvolution($productCode)
    {
        $currentMonthTurnover = $this->getStockTurnover($productCode);

        // Calculer la rotation du mois précédent
        $product = Product::where('unique_code', $productCode)->first();

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

    public function getUnsoldItems($productCode)
    {
        $product = Product::where('unique_code', $productCode)->first();

        // Quantité totale en stock
        $totalStock = $product->batches()->sum('quantity');

        // Quantité vendue
        $soldQuantity = $product->sales()->sum('quantity');

        return $totalStock - $soldQuantity;
    }

    public function getUnsoldItemsEvolution($productCode)
    {
        $product = Product::where('unique_code', $productCode)->first();

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

    public function getMonthlyDebit($productCode)
    {
        $product = Product::where('unique_code', $productCode)->first();

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
}
