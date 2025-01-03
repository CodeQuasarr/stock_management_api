<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class kpi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'stock_value', 'change_stock_value', 'stock_rotation', 'change_stock_rotation', 'unsold_items', 'change_unsold_items', 'monthly_debit', 'change_monthly_debit',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
