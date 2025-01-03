<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            // Générer un nombre aléatoire de ventes pour chaque produit (entre 1 et 10)
            $saleCount = rand(1, 10);

            for ($i = 0; $i < $saleCount; $i++) {
                // Quantité vendue (ne peut pas dépasser le stock disponible)
                $quantity = rand(1, $product->stock?->quantity);

                // Prix total de la vente
                $totalPrice = $quantity * $product->sale_price;

                // Date de vente aléatoire dans les 6 derniers mois
                $saleDate = Carbon::now()->subMonths(rand(0, 6))->subDays(rand(0, 30));

                // Enregistrer la vente
                Sale::create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                    'created_at' => $saleDate,
                    'updated_at' => $saleDate,
                ]);

                // Mettre à jour la quantité en stock
                if ($product->stock) {
                    $product->stock->quantity -= $quantity;
                    $product->stock->save();
                }
            }
        }
    }
}
