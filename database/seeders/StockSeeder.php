<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockAdjustment;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $stocks = [];
        foreach (Product::all() as $product) {
            $stocks[] = [
                'seller_id' => rand(1, 10),
                'product_id' => $product->id,
                'quantity' => rand(5, 50),
                'alert_threshold' => rand(10, 30),
                'expiration_date' => now()->addMonths(rand(6, 24))->format('Y-m-d'),
                'batch_number' => 'LOT' . rand(10000, 99999),
                'location' => 'Aisle ' . rand(1, 5) . ', Shelf ' . rand(1, 5),
            ];
        }

        // Mouvements de stock
        $stockMovements = [];
        foreach ($stocks as $index => $stock) {
            $movementCount = rand(2, 5);
            for ($i = 0; $i < $movementCount; $i++) {
                $stockMovements[] = [
                    'stock_id' => $index + 1,
                    'quantity' => rand(10, 50),
                    'type' => rand(0, 1) ? 'in' : 'out',
                    'reason' => rand(0, 1) ? 'Réapprovisionnement' : 'Vente',
                ];
            }
        }

        // Ajustements de stock
        $stockAdjustments = [];
        foreach ($stocks as $index => $stock) {
            $adjustmentCount = rand(1, 3);
            for ($i = 0; $i < $adjustmentCount; $i++) {
                $stockAdjustments[] = [
                    'stock_id' => $index + 1,
                    'quantity' => rand(-10, 10),
                    'reason' => rand(0, 1) ? 'Produit endommagé' : 'Erreur d\'inventaire',
                ];
            }
        }


        // Insérer les stocks
        foreach ($stocks as $stock) {
            Stock::create($stock);
        }

        // Insérer les mouvements de stock
        foreach ($stockMovements as $movement) {
            StockMovement::create($movement);
        }

        // Insérer les ajustements de stock
        foreach ($stockAdjustments as $adjustment) {
            StockAdjustment::create($adjustment);
        }



//        $stocks = [
//            [
//                'product_id' => 1, // Paracétamol 500mg
//                'quantity' => 100,
//                'alert_threshold' => 20,
//                'expiration_date' => '2024-12-31',
//                'batch_number' => 'LOT12345',
//                'location' => 'Aisle 1, Shelf 2',
//            ],
//            [
//                'product_id' => 2, // Ibuprofène 400mg
//                'quantity' => 75,
//                'alert_threshold' => 15,
//                'expiration_date' => '2025-06-30',
//                'batch_number' => 'LOT67890',
//                'location' => 'Aisle 1, Shelf 3',
//            ],
//            [
//                'product_id' => 3, // Amoxicilline 500mg
//                'quantity' => 50,
//                'alert_threshold' => 10,
//                'expiration_date' => '2024-11-15',
//                'batch_number' => 'LOT54321',
//                'location' => 'Aisle 2, Shelf 1',
//            ],
//            [
//                'product_id' => 4, // Oméprazole 20mg
//                'quantity' => 60,
//                'alert_threshold' => 12,
//                'expiration_date' => '2025-03-31',
//                'batch_number' => 'LOT13579',
//                'location' => 'Aisle 2, Shelf 2',
//            ],
//            [
//                'product_id' => 5, // Vitamine C 1000mg
//                'quantity' => 40,
//                'alert_threshold' => 8,
//                'expiration_date' => '2023-09-30',
//                'batch_number' => 'LOT24680',
//                'location' => 'Aisle 2, Shelf 3',
//            ],
//            [
//                'product_id' => 6, // Paracétamol 1000mg
//                'quantity' => 30,
//                'alert_threshold' => 6,
//                'expiration_date' => '2024-12-31',
//                'batch_number' => 'LOT13579',
//                'location' => 'Aisle 3, Shelf 1',
//            ],
//            // generer 7 autres stocks
//            [
//                'product_id' => 7, // Ibuprofène 600mg
//                'quantity' => 25,
//                'alert_threshold' => 5,
//                'expiration_date' => '2025-06-30',
//                'batch_number' => 'LOT67890',
//                'location' => 'Aisle 3, Shelf 2',
//            ],
//            [
//                'product_id' => 8, // Amoxicilline 250mg
//                'quantity' => 20,
//                'alert_threshold' => 4,
//                'expiration_date' => '2024-11-15',
//                'batch_number' => 'LOT54321',
//                'location' => 'Aisle 3, Shelf 3',
//            ],
//            [
//                'product_id' => 9, // Oméprazole 40mg
//                'quantity' => 15,
//                'alert_threshold' => 3,
//                'expiration_date' => '2025-03-31',
//                'batch_number' => 'LOT13579',
//                'location' => 'Aisle 4, Shelf 1',
//            ],
//            [
//                'product_id' => 10, // Vitamine C 500mg
//                'quantity' => 10,
//                'alert_threshold' => 2,
//                'expiration_date' => '2023-09-30',
//                'batch_number' => 'LOT24680',
//                'location' => 'Aisle 4, Shelf 2',
//            ],
//            [
//                'product_id' => 11, // Paracétamol 2000mg
//                'quantity' => 5,
//                'alert_threshold' => 1,
//                'expiration_date' => '2024-12-31',
//                'batch_number' => 'LOT13579',
//                'location' => 'Aisle 4, Shelf 3',
//            ],
//            [
//                'product_id' => 12, // Ibuprofène 800mg
//                'quantity' => 2,
//                'alert_threshold' => 1,
//                'expiration_date' => '2025-06-30',
//                'batch_number' => 'LOT67890',
//                'location' => 'Aisle 5, Shelf 1',
//            ],
//            [
//                'product_id' => 13, // Amoxicilline 125mg
//                'quantity' => 1,
//                'alert_threshold' => 1,
//                'expiration_date' => '2024-11-15',
//                'batch_number' => 'LOT54321',
//                'location' => 'Aisle 5, Shelf 2',
//            ],
//            [
//                'product_id' => 14, // Oméprazole 10mg
//                'quantity' => 1,
//                'alert_threshold' => 1,
//                'expiration_date' => '2025-03-31',
//                'batch_number' => 'LOT13579',
//                'location' => 'Aisle 5, Shelf 3',
//            ],
//            [
//                'product_id' => 15, // Vitamine C 250mg
//                'quantity' => 1,
//                'alert_threshold' => 1,
//                'expiration_date' => '2023-09-30',
//                'batch_number' => 'LOT24680',
//                'location' => 'Aisle 6, Shelf 1',
//            ],
//            [
//                'product_id' => 16, // Paracétamol 250mg
//                'quantity' => 1,
//                'alert_threshold' => 1,
//                'expiration_date' => '2024-12-31',
//                'batch_number' => 'LOT13579',
//                'location' => 'Aisle 6, Shelf 2',
//            ],
//            [
//                'product_id' => 17, // Ibuprofène 200mg
//                'quantity' => 1,
//                'alert_threshold' => 1,
//                'expiration_date' => '2025-06-30',
//                'batch_number' => 'LOT67890',
//                'location' => 'Aisle 6, Shelf 3',
//            ],
//            [
//                'product_id' => 18, // Amoxicilline 62.5mg
//                'quantity' => 1,
//                'alert_threshold' => 1,
//                'expiration_date' => '2024-11-15',
//                'batch_number' => 'LOT54321',
//                'location' => 'Aisle 7, Shelf 1',
//            ],
//            [
//                'product_id' => 19, // Oméprazole 5mg
//                'quantity' => 1,
//                'alert_threshold' => 1,
//                'expiration_date' => '2025-03-31',
//                'batch_number' => 'LOT13579',
//                'location' => 'Aisle 7, Shelf 2',
//            ],
//            [
//                'product_id' => 20, // Vitamine C 125mg
//                'quantity' => 1,
//                'alert_threshold' => 1,
//                'expiration_date' => '2023-09-30',
//                'batch_number' => 'LOT24680',
//                'location' => 'Aisle 7, Shelf 3',
//            ]
//
//        ];
//
//        $stockMovements = [
//            [
//                'stock_id' => 1, // Paracétamol 500mg
//                'quantity' => 50,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 1, // Paracétamol 500mg
//                'quantity' => 10,
//                'type' => 'out', // Sortie de stock
//                'reason' => 'Vente',
//            ],
//            [
//                'stock_id' => 2, // Ibuprofène 400mg
//                'quantity' => 25,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 3, // Amoxicilline 500mg
//                'quantity' => 15,
//                'type' => 'out', // Sortie de stock
//                'reason' => 'Vente',
//            ],
//            [
//                'stock_id' => 4, // Oméprazole 20mg
//                'quantity' => 20,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 5, // Vitamine C 1000mg
//                'quantity' => 10,
//                'type' => 'out', // Sortie de stock
//                'reason' => 'Vente',
//            ],
//            [
//                'stock_id' => 6, // Paracétamol 1000mg
//                'quantity' => 5,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 7, // Ibuprofène 600mg
//                'quantity' => 5,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 8, // Amoxicilline 250mg
//                'quantity' => 5,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 9, // Oméprazole 40mg
//                'quantity' => 5,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 10, // Vitamine C 500mg
//                'quantity' => 5,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 11, // Paracétamol 2000mg
//                'quantity' => 5,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 12, // Ibuprofène 800mg
//                'quantity' => 5,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 13, // Amoxicilline 125mg
//                'quantity' => 5,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 14, // Oméprazole 10mg
//                'quantity' => 5,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id' => 15, // Vitamine C 250mg
//                'quantity' => 5,
//                'type' => 'in', // Entrée de stock
//                'reason' => 'Réapprovisionnement',
//            ],
//            [
//                'stock_id
//            ]
//        ];
//
//        $stockAdjustments = [
//            [
//                'stock_id' => 1, // Paracétamol 500mg
//                'quantity' => -5, // Ajustement négatif (perte ou erreur)
//                'reason' => 'Produit endommagé',
//            ],
//            [
//                'stock_id' => 2, // Ibuprofène 400mg
//                'quantity' => 10, // Ajustement positif (ajout manuel)
//                'reason' => 'Erreur d\'inventaire',
//            ],
//            [
//                'stock_id' => 3, // Amoxicilline 500mg
//                'quantity' => -3, // Ajustement négatif (perte ou erreur)
//                'reason' => 'Produit périmé',
//            ],
//        ];
    }
}
