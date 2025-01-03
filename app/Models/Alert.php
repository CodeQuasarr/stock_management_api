<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'stock_id', 'type', 'message', 'resolved', 'created_at', 'updated_at'
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
