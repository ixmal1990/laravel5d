<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'console_id',
        'duration_days',
        'daily_rate_snapshot',
        'subtotal',
        'late_fee',
    ];

    /**
     * Get the rental transaction that owns this item (Inverse 1:N relationship).
     */
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    /**
     * Get the console rented in this item (Inverse 1:N relationship).
     */
    public function console(): BelongsTo
    {
        return $this->belongsTo(Console::class);
    }
}
