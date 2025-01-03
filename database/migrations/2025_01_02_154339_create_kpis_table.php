<?php

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
            $table->decimal('stock_value', 12, 2);
            $table->decimal('last_stock_value', 12, 2);
            $table->decimal('stock_rotation', 8, 2);
            $table->decimal('last_stock_rotation', 8, 2);
            $table->integer('unsold_items');
            $table->integer('last_unsold_items');
            $table->decimal('monthly_debit', 12, 2);
            $table->decimal('last_monthly_debit', 12, 2);
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
