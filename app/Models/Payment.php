<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_code',
        'lease_id',
        'period_month',
        'amount',
        'method',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /**
     * Get the lease contract associated with the payment (Inverse 1:N relationship).
     */
    public function lease(): BelongsTo
    {
        return $this->belongsTo(Lease::class);
    }
}
