<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Inserting sales...');
        DB::table('sales')->insert([
            // Paracétamol 500mg
            [
                'product_id' => 1,
                'quantity' => 19,
                'sale_date' => '2025-02-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 1,
                'quantity' => 4,
                'sale_date' => '2025-02-03',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Ibuprofène 400mg
            [
                'product_id' => 2,
                'quantity' => 10,
                'sale_date' => '2025-02-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Amoxicilline 500mg
            [
                'product_id' => 3,
                'quantity' => 8,
                'sale_date' => '2025-02-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'quantity' => 4,
                'sale_date' => '2025-02-02',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        $this->command->info('Sales inserted inserted successfully.');
        $this->command->info('');
    }
}
