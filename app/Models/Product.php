<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     title="Product",
 *     description="Product model",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the product"
 *     ),
 *     @OA\Property(
 *         property="unique_code",
 *         type="string",
 *         description="Unique code of the product"
 *     ),
 *     @OA\Property(
 *         property="therapeutic_category",
 *         type="string",
 *         description="Therapeutic category of the product"
 *     ),
 *     @OA\Property(
 *         property="purchase_price",
 *         type="number",
 *         format="float",
 *         description="Purchase price of the product"
 *     ),
 *     @OA\Property(
 *         property="sale_price",
 *         type="number",
 *         format="float",
 *         description="Sale price of the product"
 *     ),
 *     @OA\Property(
 *         property="profit_margin",
 *         type="number",
 *         format="float",
 *         description="Profit margin of the product"
 *     ),
 *     @OA\Property(
 *         property="manufacturer",
 *         type="string",
 *         description="Manufacturer of the product"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the product"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation date of the product"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update date of the product"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         description="Deletion date of the product"
 *     )
 * )
 */
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
