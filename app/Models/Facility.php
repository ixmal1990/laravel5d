<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description',
    ];

    /**
     * The rooms equipped with this facility (N:M relationship).
     */
    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class)
            ->withPivot('condition', 'installed_at')
            ->withTimestamps();
    }
}
