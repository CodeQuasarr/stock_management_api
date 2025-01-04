<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $currentMonthStart = now()->startOfMonth();
        $currentMonthEnd = now()->endOfMonth();

        $products = Product::all();

        foreach ($products as $product) {
            $initialQuantity = rand(20, 100); // Quantité initiale aléatoire

            // Random date between $currentMonthStart and $currentMonthEnd
            $randomDate = Carbon::createFromTimestamp(rand($currentMonthStart->timestamp, $currentMonthEnd->timestamp));

            // Créer des stocks pour chaque produit
            $stock = Stock::query()->where('product_id', $product->id)->first();

            // Créer des mouvements de stock (entrée initiale)
            StockMovement::create([
                'stock_id' => $stock->id,
                'product_batch_id' => $product->productBatch->id,
                'user_id' => 10,
                'quantity' => $stock->quantity,
                'type' => 'in',
                'reason' => 'Stock initial',
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            $saleQuantity = rand(5, 20); // Quantité vendue aléatoire
            $randomDateSale = $randomDate->addDays(rand(1, 30));
            if ($stock->quantity >= $saleQuantity) {
                Sale::create([
                    'product_id' => $product->id,
                    'product_batch_id' => $product->productBatch->id,
                    'user_id' => 10,
                    'quantity' => $saleQuantity,
                    'created_at' => $randomDateSale,
                    'updated_at' => $randomDateSale,
                ]);
                // Réduire la quantité en stock après la vente
                $stock->decrement('quantity', $saleQuantity);
                $stock->updated_at = $randomDateSale;
                $stock->save();

                // Créer un mouvement de stock (vente)
                StockMovement::create([
                    'stock_id' => $stock->id,
                    'product_batch_id' => $product->productBatch->id,
                    'user_id' => 10,
                    'quantity' => $saleQuantity,
                    'type' => 'out',
                    'reason' => 'Vente de produits',
                    'created_at' => $randomDateSale,
                ]);

            }
            // Vérifier si une alerte doit être créée (stock faible)
            if ($stock->quantity <= $stock->alert_threshold) {
                Alert::create([
                    'stock_id' => $stock->id,
                    'product_batch_id' => $product->productBatch->id,
                    'type' => 'low_stock',
                    'message' => 'Stock faible pour ' . $product->name . ' (' . $stock->quantity . ' restants)',
                    'resolved' => false,
                    'created_at' => $stock->updated_at,
                    'updated_at' => $stock->updated_at,
                ]);
            }
        }
    }
}
