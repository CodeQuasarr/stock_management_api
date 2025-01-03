<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'therapeutic_category' => 'Antidouleur et antipyrétique',
                'purchase_price' => 2.50,
                'sale_price' => 5.00,
                'profit_margin' => 2.50,
                'manufacturer' => 'Laboratoire X',
                'description' => 'Soulage la douleur et réduit la fièvre.',
            ],
            [
                'name' => 'Ibuprofène 400mg',
                'unique_code' => 'IBU400',
                'therapeutic_category' => 'Anti-inflammatoire non stéroïdien',
                'purchase_price' => 3.00,
                'sale_price' => 6.00,
                'profit_margin' => 3.00,
                'manufacturer' => 'Laboratoire Y',
                'description' => 'Soulage la douleur et l\'inflammation.',
            ],
            [
                'name' => 'Amoxicilline 500mg',
                'unique_code' => 'AMOX500',
                'therapeutic_category' => 'Antibiotique',
                'purchase_price' => 4.00,
                'sale_price' => 8.00,
                'profit_margin' => 4.00,
                'manufacturer' => 'Laboratoire Z',
                'description' => 'Traite les infections bactériennes.',
            ],
            [
                'name' => 'Oméprazole 20mg',
                'unique_code' => 'OME20',
                'therapeutic_category' => 'Antiulcéreux',
                'purchase_price' => 3.50,
                'sale_price' => 7.00,
                'profit_margin' => 3.50,
                'manufacturer' => 'Laboratoire A',
                'description' => 'Traite les brûlures d\'estomac et les ulcères.',
            ],
            [
                'name' => 'Vitamine C 1000mg',
                'unique_code' => 'VITC1000',
                'therapeutic_category' => 'Complément alimentaire',
                'purchase_price' => 1.50,
                'sale_price' => 3.00,
                'profit_margin' => 1.50,
                'manufacturer' => 'Laboratoire B',
                'description' => 'Renforce le système immunitaire.',
            ],
            [
                'name' => 'Doliprane 1000mg',
                'unique_code' => 'DOL1000',
                'therapeutic_category' => 'Antidouleur et antipyrétique',
                'purchase_price' => 3.00,
                'sale_price' => 6.00,
                'profit_margin' => 3.00,
                'manufacturer' => 'Laboratoire C',
                'description' => 'Soulage la douleur et réduit la fièvre.',
            ],
            [
                'name' => 'Aspirine 500mg',
                'unique_code' => 'ASP500',
                'therapeutic_category' => 'Antidouleur et antipyrétique',
                'purchase_price' => 2.00,
                'sale_price' => 4.00,
                'profit_margin' => 2.00,
                'manufacturer' => 'Laboratoire D',
                'description' => 'Soulage la douleur et réduit l\'inflammation.',
            ],
            [
                'name' => 'Levothyrox 25µg',
                'unique_code' => 'LEVO25',
                'therapeutic_category' => 'Hormone thyroïdienne',
                'purchase_price' => 5.00,
                'sale_price' => 10.00,
                'profit_margin' => 5.00,
                'manufacturer' => 'Laboratoire E',
                'description' => 'Traite l\'hypothyroïdie.',
            ],
            [
                'name' => 'Metformine 500mg',
                'unique_code' => 'MET500',
                'therapeutic_category' => 'Antidiabétique',
                'purchase_price' => 2.50,
                'sale_price' => 5.00,
                'profit_margin' => 2.50,
                'manufacturer' => 'Laboratoire F',
                'description' => 'Traite le diabète de type 2.',
            ],
            [
                'name' => 'Atorvastatine 20mg',
                'unique_code' => 'ATO20',
                'therapeutic_category' => 'Hypolipémiant',
                'purchase_price' => 4.00,
                'sale_price' => 8.00,
                'profit_margin' => 4.00,
                'manufacturer' => 'Laboratoire G',
                'description' => 'Réduit le cholestérol.',
            ],
            [
                'name' => 'Loratadine 10mg',
                'unique_code' => 'LORA10',
                'therapeutic_category' => 'Antihistaminique',
                'purchase_price' => 1.50,
                'sale_price' => 3.00,
                'profit_margin' => 1.50,
                'manufacturer' => 'Laboratoire H',
                'description' => 'Traite les allergies.',
            ],
            [
                'name' => 'Diclofénac 50mg',
                'unique_code' => 'DIC50',
                'therapeutic_category' => 'Anti-inflammatoire non stéroïdien',
                'purchase_price' => 3.00,
                'sale_price' => 6.00,
                'profit_margin' => 3.00,
                'manufacturer' => 'Laboratoire I',
                'description' => 'Soulage la douleur et l\'inflammation.',
            ],
            [
                'name' => 'Tramadol 50mg',
                'unique_code' => 'TRA50',
                'therapeutic_category' => 'Antidouleur',
                'purchase_price' => 4.50,
                'sale_price' => 9.00,
                'profit_margin' => 4.50,
                'manufacturer' => 'Laboratoire J',
                'description' => 'Soulage les douleurs modérées à sévères.',
            ],
            [
                'name' => 'Cétirizine 10mg',
                'unique_code' => 'CET10',
                'therapeutic_category' => 'Antihistaminique',
                'purchase_price' => 1.80,
                'sale_price' => 3.60,
                'profit_margin' => 1.80,
                'manufacturer' => 'Laboratoire K',
                'description' => 'Traite les allergies.',
            ],
            [
                'name' => 'Simvastatine 20mg',
                'unique_code' => 'SIM20',
                'therapeutic_category' => 'Hypolipémiant',
                'purchase_price' => 3.50,
                'sale_price' => 7.00,
                'profit_margin' => 3.50,
                'manufacturer' => 'Laboratoire L',
                'description' => 'Réduit le cholestérol.',
            ],
            [
                'name' => 'Diazépam 5mg',
                'unique_code' => 'DIA5',
                'therapeutic_category' => 'Anxiolytique',
                'purchase_price' => 2.00,
                'sale_price' => 4.00,
                'profit_margin' => 2.00,
                'manufacturer' => 'Laboratoire M',
                'description' => 'Traite l\'anxiété et les troubles du sommeil.',
            ],
            [
                'name' => 'Fluoxétine 20mg',
                'unique_code' => 'FLU20',
                'therapeutic_category' => 'Antidépresseur',
                'purchase_price' => 3.00,
                'sale_price' => 6.00,
                'profit_margin' => 3.00,
                'manufacturer' => 'Laboratoire N',
                'description' => 'Traite la dépression.',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
