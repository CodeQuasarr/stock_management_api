<?php

namespace Database\Seeders;

use App\Models\ProductBatch;
use App\Models\Sale;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Paracétamol 500mg',
                'unique_code' => 'PARA500',
                'therapeutic_category' => 'Antidouleur',
                'purchase_price' => 5.00,
                'sale_price' => 10.00,
                'manufacturer' => 'PharmaCorp',
                'description' => 'Antidouleur et antipyrétique. Soulage la douleur et la fièvre.',
            ],
            [
                'name' => 'Ibuprofène 400mg',
                'unique_code' => 'IBU400',
                'therapeutic_category' => 'Anti-inflammatoire',
                'purchase_price' => 7.00,
                'sale_price' => 14.00,
                'manufacturer' => 'Medico',
                'description' => 'Anti-inflammatoire non stéroïdien. Soulage la douleur et l\'inflammation.',
            ],
            [
                'name' => 'Amoxicilline 500mg',
                'unique_code' => 'AMOX500',
                'therapeutic_category' => 'Antibiotique',
                'purchase_price' => 10.00,
                'sale_price' => 20.00,
                'manufacturer' => 'BioPharm',
                'description' => 'Antibiotique à large spectre. Traite les infections bactériennes.',
            ]
        ];
        DB::table('products')->insert($products);

        // Lots pour l'Ibuprofène 400mg
        $productBatchs = [
            [
                'product_id' => 1,
                'expiration_date' => Carbon::now()->addMonths(12)->toDateString(),
                'quantity' => 100,
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subMonths(2),
            ],
            [
                'product_id' => 1,
                'expiration_date' => Carbon::now()->addMonths(10)->toDateString(),
                'quantity' => 150,
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'product_id' => 1,
                'expiration_date' => Carbon::now()->addMonths(8)->toDateString(),
                'quantity' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 2,
                'expiration_date' => Carbon::now()->addMonths(18)->toDateString(),
                'quantity' => 80,
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now()->subMonths(3),
            ],
            [
                'product_id' => 2,
                'expiration_date' => Carbon::now()->addMonths(18)->toDateString(),
                'quantity' => 80,
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now()->subMonths(3),
            ],
            [
                'product_id' => 2,
                'expiration_date' => Carbon::now()->addMonths(15)->toDateString(),
                'quantity' => 120,
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ],
            [
                'product_id' => 3,
                'expiration_date' => Carbon::now()->addMonths(24)->toDateString(),
                'quantity' => 50,
                'created_at' => Carbon::now()->subMonths(4),
                'updated_at' => Carbon::now()->subMonths(4),
            ],
            [
                'product_id' => 3,
                'expiration_date' => Carbon::now()->addMonths(20)->toDateString(),
                'quantity' => 100,
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ]
        ];
        DB::table('product_batches')->insert($productBatchs);

        // Ventes pour le Paracétamol 500mg
        $sales = [
            [
                'product_id' => 1,
                'quantity' => 30,
                'sale_date' => Carbon::now()->subMonth()->addDays(5)->toDateString(),
            ],
            [
                'product_id' => 1,
                'quantity' => 70,
                'sale_date' => Carbon::now()->toDateString(),
            ],
            [
                'product_id' => 1,
                'quantity' => 40,
                'sale_date' => Carbon::now()->subDays(3)->toDateString(),
            ],
            [
                'product_id' => 2,
                'quantity' => 20,
                'sale_date' => Carbon::now()->subMonth()->toDateString(),
            ],
            [
                'product_id' => 2,
                'quantity' => 15,
                'sale_date' => Carbon::now()->subMonth()->addDays(10)->toDateString(),
            ],
            [
                'product_id' => 2,
                'quantity' => 25,
                'sale_date' => Carbon::now()->toDateString(),
            ],
            [
                'product_id' => 3,
                'quantity' => 10,
                'sale_date' => Carbon::now()->subMonth()->toDateString(),
            ],
            [
                'product_id' => 3,
                'quantity' => 5,
                'sale_date' => Carbon::now()->subMonth()->addDays(7)->toDateString(),
            ],
            [
                'product_id' => 3,
                'quantity' => 15,
                'sale_date' => Carbon::now()->toDateString(),
            ]
        ];
        DB::table('sales')->insert($sales);

        // Stocks
        // Mouvements pour le Paracétamol 500mg
        $paracetamolBatches = ProductBatch::where('product_id', 1)->get();
        $paracetamolSales = Sale::where('product_id', 1)->get();

        // Entrées de stock pour le Paracétamol 500mg
        foreach ($paracetamolBatches as $batch) {
            StockMovement::create([
                'product_id' => $batch->product_id,
                'batch_id' => $batch->id,
                'type' => 'in',
                'reason' => 'Entrée de stock',
                'quantity' => $batch->quantity,
                'date' => $batch->created_at,
            ]);
        }

        // Sorties de stock pour le Paracétamol 500mg
        foreach ($paracetamolSales as $sale) {
            StockMovement::create([
                'product_id' => $sale->product_id,
                'batch_id' => $paracetamolBatches->first()->id, // On associe la vente au premier lot disponible
                'type' => 'out',
                'reason' => 'Vente',
                'quantity' => $sale->quantity,
                'date' => $sale->sale_date,
            ]);
        }

        // Mouvements pour l'Ibuprofène 400mg
        $ibuprofenBatches = ProductBatch::where('product_id', 2)->get();
        $ibuprofenSales = Sale::where('product_id', 2)->get();

        // Entrées de stock pour l'Ibuprofène 400mg
        foreach ($ibuprofenBatches as $batch) {
            StockMovement::create([
                'product_id' => $batch->product_id,
                'batch_id' => $batch->id,
                'type' => 'in',
                'reason' => 'Entrée de stock',
                'quantity' => $batch->quantity,
                'date' => $batch->created_at,
            ]);
        }

        // Sorties de stock pour l'Ibuprofène 400mg
        foreach ($ibuprofenSales as $sale) {
            StockMovement::create([
                'product_id' => $sale->product_id,
                'batch_id' => $ibuprofenBatches->first()->id, // On associe la vente au premier lot disponible
                'type' => 'out',
                'reason' => 'Vente',
                'quantity' => $sale->quantity,
                'date' => $sale->sale_date,
            ]);
        }

        // Mouvements pour l'Amoxicilline 500mg
        $amoxicillinBatches = ProductBatch::where('product_id', 3)->get();
        $amoxicillinSales = Sale::where('product_id', 3)->get();

        // Entrées de stock pour l'Amoxicilline 500mg
        foreach ($amoxicillinBatches as $batch) {
            StockMovement::create([
                'product_id' => $batch->product_id,
                'batch_id' => $batch->id,
                'type' => 'in',
                'reason' => 'Entrée de stock',
                'quantity' => $batch->quantity,
                'date' => $batch->created_at,
            ]);
        }

        // Sorties de stock pour l'Amoxicilline 500mg
        foreach ($amoxicillinSales as $sale) {
            StockMovement::create([
                'product_id' => $sale->product_id,
                'batch_id' => $amoxicillinBatches->first()->id, // On associe la vente au premier lot disponible
                'type' => 'out',
                'reason' => 'Vente',
                'quantity' => $sale->quantity,
                'date' => $sale->sale_date,
            ]);
        }

    }
}
