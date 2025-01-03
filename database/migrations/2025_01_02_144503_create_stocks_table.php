<?php

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\Stock;
use App\Models\User;
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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class);
            $table->string('location');
            $table->integer('quantity')->unsigned();
            $table->integer('alert_threshold')->default(20)->unsigned();
            $table->timestamps();
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Stock::class);
            $table->foreignIdFor(ProductBatch::class);
            $table->foreignIdFor(User::class);
            $table->integer('quantity')->unsigned();
            $table->enum('type', ['in', 'out', 'adjustment']);
            $table->text('reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('stock_movements');
    }
};
