<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="StockMovement",
 *     type="object",
 *     title="StockMovement",
 *     description="Stock Movement model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the stock movement"
 *     ),
 *     @OA\Property(
 *         property="product_id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the product"
 *     ),
 *     @OA\Property(
 *         property="quantity",
 *         type="integer",
 *         description="Quantity of the movement"
 *     ),
 *     @OA\Property(
 *         property="movement_type",
 *         type="string",
 *         description="Type of the movement (IN or OUT)"
 *     ),
 *     @OA\Property(
 *         property="reason",
 *         type="string",
 *         description="Reason for the movement"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date-time",
 *         description="Date of the movement"
 *     ),
 *     @OA\Property(
 *         property="batch_id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the batch"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation date of the movement"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update date of the movement"
 *     )
 * )
 */
class StockMovement extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'product_id', 'batch_id', 'type', 'quantity', 'date', 'reason',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(ProductBatch::class);
    }
}
