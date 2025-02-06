<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Inserting stock movements...');
        DB::table('stock_movements')->insert([
            [
                'product_id' => 1,
                'batch_id' => 1,
                'quantity' => 25,
                'type' => 'in',
                'reason' => 'Stock initial',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-01 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 1,
                'batch_id' => 1,
                'quantity' => 19,
                'type' => 'out',
                'reason' => 'Ventes',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-02 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 1,
                'batch_id' => 2,
                'quantity' => 20,
                'type' => 'in',
                'reason' => 'Réapprovisionnement',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-03 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 1,
                'batch_id' => 2,
                'quantity' => 4,
                'type' => 'out',
                'reason' => 'Ventes',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-04 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 2,
                'batch_id' => 1,
                'quantity' => 25,
                'type' => 'in',
                'reason' => 'Stock initial',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-01 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 2,
                'batch_id' => 2,
                'quantity' => 10,
                'type' => 'in',
                'reason' => 'Réapprovisionnement',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-03 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 2,
                'batch_id' => 1,
                'quantity' => 27,
                'type' => 'out',
                'reason' => 'Ventes',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-02 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'batch_id' => 1,
                'quantity' => 2,
                'type' => 'in',
                'reason' => 'Stock initial',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-01 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'batch_id' => 1,
                'quantity' => 5,
                'type' => 'in',
                'reason' => 'Réapprovisionnement',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-02 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'batch_id' => 1,
                'quantity' => 8,
                'type' => 'in',
                'reason' => 'Réapprovisionnement',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-02 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'batch_id' => 2,
                'quantity' => 12,
                'type' => 'out',
                'reason' => 'Ventes',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-04 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'batch_id' => 2,
                'quantity' => 14,
                'type' => 'in',
                'reason' => 'Réapprovisionnement',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-03 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'batch_id' => 2,
                'quantity' => 8,
                'type' => 'in',
                'reason' => 'Réapprovisionnement',
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', '2025-02-03 00:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $this->command->info('Stock movements inserted successfully.');
        $this->command->info('');
    }
}
