<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Console extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'serial_number',
        'name',
        'status',
        'daily_rate',
        'condition',
    ];

    /**
     * Get the category that owns the console (Inverse 1:N relationship).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The games installed on this console (N:M relationship with pivot data).
     */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class)
            ->withPivot('installed_at', 'storage_size_gb')
            ->withTimestamps();
    }

    /**
     * Get the rental items involving this console (1:N relationship).
     */
    public function rentalItems(): HasMany
    {
        return $this->hasMany(RentalItem::class);
    }

    /**
     * Get the maintenance logs for this console (1:N relationship).
     */
    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class);
    }
}
