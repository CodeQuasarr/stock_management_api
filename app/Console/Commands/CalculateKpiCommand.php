<?php

namespace App\Console\Commands;

use App\Actions\Statistics\Kpis\CalculateCurrentStockAction;
use App\Actions\Statistics\Kpis\CalculateInitialQuantityAction;
use App\Actions\Statistics\Kpis\CalculateMonthlyDebitAction;
use App\Actions\Statistics\Kpis\CalculateUnsoldItemsAction;
use App\Actions\Statistics\Kpis\CMVCalculatorAction;
use App\Models\kpi;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateKpiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kpi:calculate {stock_id=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the KPIs for the stock';

    public function __construct(
        private readonly CalculateCurrentStockAction $calculateCurrentStockAction,
        private readonly CMVCalculatorAction $cmvCalculatorAction,
        private readonly CalculateInitialQuantityAction $calculateInitialQuantityAction,
        private readonly CalculateUnsoldItemsAction $calculateUnsoldItemsAction,
        private readonly CalculateMonthlyDebitAction $calculateMonthlyDebitAction,
    )
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info($this->description);

        $stoksId = $this->argument('stock_id');
        $stockModel = Stock::query();
        if ($stoksId !== 'all') {
            $stokModel = $stockModel->where('id', $stoksId);
        }
        $stocks = $stockModel->get();
        // Dates pour le mois actuel
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        // Dates pour le mois dernier
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $stocks->each(function ($stock) use ($lastMonthEnd, $lastMonthStart, $currentMonthStart, $currentMonthEnd) {
            $this->info("Calculating KPIs for stock {$stock->id}");

            $currentQuantity = $this->calculateCurrentStockAction->execute($stock, $currentMonthStart, $currentMonthEnd);

            // Récupérer le produit associé au stock
            $product = $stock->product;

            // Calculer la valeur du stock actuel
            $currentStockValue = $currentQuantity * $product->purchase_price;

            // Calculer le coût des marchandises vendues (CMV) pour ce stock et le mois actuel
            $currentCMV = $this->cmvCalculatorAction->execute($product, $currentMonthStart, $currentMonthEnd);

            // Calculer le stock moyen pour ce stock
            $initialQuantity = $this->calculateInitialQuantityAction->execute($stock, $currentMonthStart);

            $initialStockValue = $initialQuantity * $product->purchase_price;
            $averageStock = ($initialStockValue + $currentStockValue) / 2;

            // Calculer la rotation des stocks pour ce stock
            $currentStockRotation = $averageStock > 0 ? ($currentCMV / $averageStock) : 0;

            // Calculer les articles invendus pour ce stock
            $currentUnsoldItems = $this->calculateUnsoldItemsAction->execute($product, $currentQuantity, $currentMonthStart, $currentMonthEnd);

            // Calculer le débit mensuel pour ce stock
            $currentMonthlyDebit = $this->calculateMonthlyDebitAction->execute($product, $currentMonthStart, $currentMonthEnd);

            // Récupérer les KPI du mois dernier pour ce stock
            $lastKpi = $stock->kpis()
                ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                ->first();

            // Calculer les changements en pourcentage
            $changeStockValue = ($lastKpi && $lastKpi->stock_value != 0)
                ? (($currentStockValue - $lastKpi->stock_value) / $lastKpi->stock_value) * 100
                : 0;

            $changeStockRotation = ($lastKpi && $lastKpi->stock_rotation != 0)
                ? (($currentStockRotation - $lastKpi->stock_rotation) / $lastKpi->stock_rotation) * 100
                : 0;

            $changeUnsoldItems = ($lastKpi && $lastKpi->unsold_items != 0)
                ? (($currentUnsoldItems - $lastKpi->unsold_items) / $lastKpi->unsold_items) * 100
                : 0;

            $changeMonthlyDebit = ($lastKpi && $lastKpi->monthly_debit != 0)
                ? (($currentMonthlyDebit - $lastKpi->monthly_debit) / $lastKpi->monthly_debit) * 100
                : 0;

            // Enregistrer les KPI dans la base de données
            Kpi::create([
                'stock_id' => $stock->id,
                'stock_value' => $currentStockValue,
                'change_stock_value' => $changeStockValue,
                'stock_rotation' => $currentStockRotation,
                'change_stock_rotation' => $changeStockRotation,
                'unsold_items' => $currentUnsoldItems,
                'change_unsold_items' => $changeUnsoldItems,
                'monthly_debit' => $currentMonthlyDebit,
                'change_monthly_debit' => $changeMonthlyDebit,
            ]);

            $this->info("KPIs for stock ID $stock->id calculated and saved successfully!");
        });
    }
}
