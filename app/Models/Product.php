<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'unique_code', 'therapeutic_category', 'purchase_price', 'sale_price', 'profit_margin', 'manufacturer', 'description'
    ];

    public function batches(): HasMany
    {
        return $this->hasMany(ProductBatch::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function stockTotals(): int
    {
        $totalQuantity = 0;
        $this->stockMovements()->each(function ($stockMovement) use (&$totalQuantity) {
            if ($stockMovement->type === 'in') {
                $totalQuantity += $stockMovement->quantity;
            } else {
                $totalQuantity -= $stockMovement->quantity;
            }
        });

        return $totalQuantity;
    }
}
