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

class StockSeeder extends Seeder
{

    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@pharmacy.com',
            'password' => bcrypt('password'),
        ]);
        $products = [
            [
                'name' => 'Paracétamol 500mg',
                'unique_code' => 'PARA500',
                'therapeutic_category' => 'Antidouleur et antipyrétique',
                'purchase_price' => 2.50,
                'sale_price' => 5.00,
                'manufacturer' => 'Laboratoire X',
                'description' => 'Soulage la douleur et réduit la fièvre.',
            ],
            [
                'name' => 'Ibuprofène 400mg',
                'unique_code' => 'IBU400',
                'therapeutic_category' => 'Anti-inflammatoire non stéroïdien',
                'purchase_price' => 3.00,
                'sale_price' => 6.00,
                'manufacturer' => 'Laboratoire Y',
                'description' => 'Soulage la douleur et l\'inflammation.',
            ],
            [
                'name' => 'Amoxicilline 500mg',
                'unique_code' => 'AMOX500',
                'therapeutic_category' => 'Antibiotique',
                'purchase_price' => 4.00,
                'sale_price' => 8.00,
                'manufacturer' => 'Laboratoire Z',
                'description' => 'Traite les infections bactériennes.',
            ],
            [
                'name' => 'Oméprazole 20mg',
                'unique_code' => 'OME20',
                'therapeutic_category' => 'Antiulcéreux',
                'purchase_price' => 3.50,
                'sale_price' => 7.00,
                'manufacturer' => 'Laboratoire A',
                'description' => 'Traite les brûlures d\'estomac et les ulcères.',
            ],
            [
                'name' => 'Vitamine C 1000mg',
                'unique_code' => 'VITC1000',
                'therapeutic_category' => 'Complément alimentaire',
                'purchase_price' => 1.50,
                'sale_price' => 3.00,
                'manufacturer' => 'Laboratoire B',
                'description' => 'Renforce le système immunitaire.',
            ],
            [
                'name' => 'Doliprane 1000mg',
                'unique_code' => 'DOL1000',
                'therapeutic_category' => 'Antidouleur et antipyrétique',
                'purchase_price' => 3.00,
                'sale_price' => 6.00,
                'manufacturer' => 'Laboratoire C',
                'description' => 'Soulage la douleur et réduit la fièvre.',
            ],
            [
                'name' => 'Aspirine 500mg',
                'unique_code' => 'ASP500',
                'therapeutic_category' => 'Antidouleur et antipyrétique',
                'purchase_price' => 2.00,
                'sale_price' => 4.00,
                'manufacturer' => 'Laboratoire D',
                'description' => 'Soulage la douleur et réduit l\'inflammation.',
            ],
            [
                'name' => 'Levothyrox 25µg',
                'unique_code' => 'LEVO25',
                'therapeutic_category' => 'Hormone thyroïdienne',
                'purchase_price' => 5.00,
                'sale_price' => 10.00,
                'manufacturer' => 'Laboratoire E',
                'description' => 'Traite l\'hypothyroïdie.',
            ],
            [
                'name' => 'Metformine 500mg',
                'unique_code' => 'MET500',
                'therapeutic_category' => 'Antidiabétique',
                'purchase_price' => 2.50,
                'sale_price' => 5.00,
                'manufacturer' => 'Laboratoire F',
                'description' => 'Traite le diabète de type 2.',
            ],
            [
                'name' => 'Atorvastatine 20mg',
                'unique_code' => 'ATO20',
                'therapeutic_category' => 'Hypolipémiant',
                'purchase_price' => 4.00,
                'sale_price' => 8.00,
                'manufacturer' => 'Laboratoire G',
                'description' => 'Réduit le cholestérol.',
            ],
            [
                'name' => 'Loratadine 10mg',
                'unique_code' => 'LORA10',
                'therapeutic_category' => 'Antihistaminique',
                'purchase_price' => 1.50,
                'sale_price' => 3.00,
                'manufacturer' => 'Laboratoire H',
                'description' => 'Traite les allergies.',
            ],
            [
                'name' => 'Diclofénac 50mg',
                'unique_code' => 'DIC50',
                'therapeutic_category' => 'Anti-inflammatoire non stéroïdien',
                'purchase_price' => 3.00,
                'sale_price' => 6.00,
                'manufacturer' => 'Laboratoire I',
                'description' => 'Soulage la douleur et l\'inflammation.',
            ],
            [
                'name' => 'Tramadol 50mg',
                'unique_code' => 'TRA50',
                'therapeutic_category' => 'Antidouleur',
                'purchase_price' => 4.50,
                'sale_price' => 9.00,
                'manufacturer' => 'Laboratoire J',
                'description' => 'Soulage les douleurs modérées à sévères.',
            ],
            [
                'name' => 'Cétirizine 10mg',
                'unique_code' => 'CET10',
                'therapeutic_category' => 'Antihistaminique',
                'purchase_price' => 1.80,
                'sale_price' => 3.60,
                'manufacturer' => 'Laboratoire K',
                'description' => 'Traite les allergies.',
            ],
            [
                'name' => 'Simvastatine 20mg',
                'unique_code' => 'SIM20',
                'therapeutic_category' => 'Hypolipémiant',
                'purchase_price' => 3.50,
                'sale_price' => 7.00,
                'manufacturer' => 'Laboratoire L',
                'description' => 'Réduit le cholestérol.',
            ],
            [
                'name' => 'Diazépam 5mg',
                'unique_code' => 'DIA5',
                'therapeutic_category' => 'Anxiolytique',
                'purchase_price' => 2.00,
                'sale_price' => 4.00,
                'manufacturer' => 'Laboratoire M',
                'description' => 'Traite l\'anxiété et les troubles du sommeil.',
            ],
            [
                'name' => 'Fluoxétine 20mg',
                'unique_code' => 'FLU20',
                'therapeutic_category' => 'Antidépresseur',
                'purchase_price' => 3.00,
                'sale_price' => 6.00,
                'manufacturer' => 'Laboratoire N',
                'description' => 'Traite la dépression.',
            ],
        ];

        $currentMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $currentMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        foreach ($products as $productData) {
            $product = Product::create($productData);
            $initialQuantity = rand(20, 100); // Quantité initiale aléatoire

            // Créer des lots de produits pour chaque produit
            $batch = ProductBatch::create([
                'product_id' => $product->id,
                'expiration_date' => now()->addYears(2), // Date d'expiration dans 2 ans
                'batch_number' => 'BATCH-' . $product->unique_code,
            ]);

            // Random date between $currentMonthStart and $currentMonthEnd
            $randomDate = Carbon::createFromTimestamp(rand($currentMonthStart->timestamp, $currentMonthEnd->timestamp));

            // Créer des stocks pour chaque produit
            $stock = Stock::create([
                'seller_id' => rand(1, 10),
                'product_id' => $product->id,
                'location' => 'Entrepôt A',
                'quantity' => $initialQuantity, // Quantité initiale
                'alert_threshold' => 20,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            // Créer des mouvements de stock (entrée initiale)
            StockMovement::create([
                'stock_id' => $stock->id,
                'product_batch_id' => $batch->id,
                'user_id' => $user->id,
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
                    'product_batch_id' => $batch->id,
                    'user_id' => $user->id,
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
                    'product_batch_id' => $batch->id,
                    'user_id' => $user->id,
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
                    'product_batch_id' => $batch->id,
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
