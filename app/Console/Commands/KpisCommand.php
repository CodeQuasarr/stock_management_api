<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\statistics\StockStatisticService;
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
    protected $description = 'Calculate KPIs for all products';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();

            $stockStatisticService = new StockStatisticService();
            $products = Product::all();

            foreach ($products as $product) {
                $stockStatisticService->calculateMonthlyKpi($product->getKey());
                DB::commit();
            }
            logger()->info('KPIs have been successfully calculated for all products.');

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('An error occurred while calculating KPIs: ' . $e->getMessage());
            $this->error('An error occurred while calculating KPIs: ' . $e->getMessage());
        }
    }


}
