<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = [
        'lease_code',
        'tenant_id',
        'room_id',
        'start_date',
        'end_date',
        'monthly_rent_snapshot',
        'deposit_amount',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the tenant user that holds this lease (Inverse 1:N relationship).
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Get the room leased in this contract (Inverse 1:N relationship).
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the payment records for this lease (1:N relationship).
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the latest payment for this lease (HasOne / LatestOfMany relationship).
     */
    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }
}
