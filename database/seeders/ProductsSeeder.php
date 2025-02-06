<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Inserting products...');
        DB::table('products')->insert([
            [
                'name' => 'Paracétamol 500mg',
                'unique_code' => 'PARA500',
                'therapeutic_category' => 'Analgésique',
                'purchase_price' => 5.00,
                'sale_price' => 10.00,
                'manufacturer' => 'Laboratoire X',
                'description' => 'Analgésique utilisé pour soulager la douleur',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ibuprofène 400mg',
                'unique_code' => 'IBUP400',
                'therapeutic_category' => 'Anti-inflammatoire',
                'purchase_price' => 5.00,
                'sale_price' => 10.00,
                'manufacturer' => 'Laboratoire Y',
                'description' => 'Anti-inflammatoire utilisé contre la douleur et la fièvre',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Amoxicilline 500mg',
                'unique_code' => 'AMOX500',
                'therapeutic_category' => 'Antibiotique',
                'purchase_price' => 12.00,
                'sale_price' => 26.00,
                'manufacturer' => 'Laboratoire Z',
                'description' => 'Antibiotique pour traiter les infections bactériennes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
        $this->command->info('Products inserted successfully.');
        $this->command->info('');
    }
}
