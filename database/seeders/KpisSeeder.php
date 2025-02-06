<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KpisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Inserting KPIS...');
        DB::table('kpis')->insert([
            [
                'product_id' => 1,
                'stock_value' => 500.00,
                'change_stock_value' => 10.00,
                'stock_rotation' => 5.00,
                'change_stock_rotation' => 0.50,
                'unsold_items' => 10,
                'change_unsold_items' => 2.00,
            ],
            [
                'product_id' => 2,
                'stock_value' => 700.00,
                'change_stock_value' => 20.00,
                'stock_rotation' => 7.00,
                'change_stock_rotation' => 0.70,
                'unsold_items' => 15,
                'change_unsold_items' => 3.00,
            ],
            [
                'product_id' => 3,
                'stock_value' => 1000.00,
                'change_stock_value' => 30.00,
                'stock_rotation' => 10.00,
                'change_stock_rotation' => 1.00,
                'unsold_items' => 20,
                'change_unsold_items' => 4.00,
            ]
        ]);
    }
}
