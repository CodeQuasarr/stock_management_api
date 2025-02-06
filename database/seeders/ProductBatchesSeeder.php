<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductBatchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Inserting product batches...');
        DB::table('product_batches')->insert([
            [
                'product_id' => 1,
                'expiration_date' => '2025-02-04',
                'quantity' => 25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 1,
                'expiration_date' => '2025-12-10',
                'quantity' => 20,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 2,
                'expiration_date' => '2025-02-04',
                'quantity' => 25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 2,
                'expiration_date' => '2025-05-08',
                'quantity' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'expiration_date' => '2025-02-04',
                'quantity' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'expiration_date' => '2025-02-20',
                'quantity' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'expiration_date' => '2025-05-05',
                'quantity' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'expiration_date' => '2026-02-20',
                'quantity' => 14,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'expiration_date' => '2025-12-10',
                'quantity' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        $this->command->info('Product batches inserted successfully.');
        $this->command->info('');
    }
}
