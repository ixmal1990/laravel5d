<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_code',
        'user_id',
        'start_time',
        'end_time',
        'total_price',
        'deposit_amount',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the user that made the rental (Inverse 1:N relationship).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the rental items for this rental transaction (1:N relationship).
     */
    public function rentalItems(): HasMany
    {
        return $this->hasMany(RentalItem::class);
    }

    /**
     * Get the consoles rented in this transaction (N:M relationship through rental_items).
     */
    public function consoles(): BelongsToMany
    {
        return $this->belongsToMany(Console::class, 'rental_items')
            ->withPivot('duration_days', 'daily_rate_snapshot', 'subtotal', 'late_fee')
            ->withTimestamps();
    }

    /**
     * Get the payment associated with the rental (1:1 relationship).
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
