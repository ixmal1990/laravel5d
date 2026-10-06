<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_daily_rate',
    ];

    /**
     * Get the consoles in this category (1:N relationship).
     */
    public function consoles(): HasMany
    {
        return $this->hasMany(Console::class);
    }

    /**
     * Get all rental items for consoles in this category (Has-Many-Through relationship).
     */
    public function rentalItems(): HasManyThrough
    {
        return $this->hasManyThrough(RentalItem::class, Console::class);
    }
}
