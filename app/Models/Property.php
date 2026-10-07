<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_type_id',
        'owner_id',
        'name',
        'address',
        'city',
        'description',
        'rules',
    ];

    /**
     * Get the type of property (Inverse 1:N relationship).
     */
    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * Get the owner user of the property (Inverse 1:N relationship).
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the rooms in this property (1:N relationship).
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get all leases for rooms in this property (Has-Many-Through relationship).
     */
    public function leases(): HasManyThrough
    {
        return $this->hasManyThrough(Lease::class, Room::class);
    }
}
