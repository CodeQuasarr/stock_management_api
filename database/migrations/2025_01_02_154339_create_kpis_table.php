<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kpis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class);
            $table->decimal('stock_value', 12, 2);
            $table->decimal('change_stock_value', 12, 2);
            $table->decimal('stock_rotation', 8, 2);
            $table->decimal('change_stock_rotation', 8, 2);
            $table->integer('unsold_items');
            $table->decimal('change_unsold_items', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpis');
    }
};
