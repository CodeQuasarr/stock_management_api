<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AlertStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = Stock::all();

        foreach ($stocks as $stock) {
            // 1. Alerte pour les produits proches de la péremption
            if ($stock->expiration_date <= Carbon::now()->addMonths(2)) {
                Alert::create([
                    'stock_id' => $stock->id,
                    'type' => 'expiration',
                    'message' => 'Le produit ' . $stock->product->name . ' expire le ' . $stock->expiration_date,
                    'resolved' => false,
                ]);
            }

            // 2. Alerte pour la rupture de stock
            if ($stock->quantity == 0) {
                Alert::create([
                    'stock_id' => $stock->id,
                    'type' => 'out_of_stock',
                    'message' => 'Le produit ' . $stock->product->name . ' est en rupture de stock.',
                    'resolved' => false,
                ]);
            }

            // 3. Alerte pour le stock sous le seuil minimal
            if ($stock->quantity < $stock->alert_threshold) {
                Alert::create([
                    'stock_id' => $stock->id,
                    'type' => 'low_stock',
                    'message' => 'Le produit ' . $stock->product->name . ' est en dessous du seuil minimal (' . $stock->alert_threshold . ' unités).',
                    'resolved' => false,
                ]);
            }
        }
    }
}
