<?php

namespace App\Console\Commands;

use App\Models\kpi;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Services\statistics\StockStatisticService;
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
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            $products = Product::all();

            $products->each(function ($product) {
                $stockStatisticService = new StockStatisticService();
                $success = kpi::create([
                    'product_id' => $product->getKey(),
                    'stock_value' => $stockStatisticService->getTotalStockValue($product->unique_code),
                    'change_stock_value' => $stockStatisticService->getStockValueEvolution($product->unique_code),
                    'stock_rotation' => $stockStatisticService->getStockTurnover($product->unique_code),
                    'change_stock_rotation' => $stockStatisticService->getStockTurnoverEvolution($product->unique_code),
                    'unsold_items' => $stockStatisticService->getUnsoldItems($product->unique_code),
                    'change_unsold_items' => $stockStatisticService->getUnsoldItemsEvolution($product->unique_code),
                ]);
                $this->info('KPIs have been generated successfully.' . $product->name);
                DB::commit();
            });

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('An error occurred while calculating KPIs: ' . $e->getMessage());
        }
    }


}
