<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'publisher',
        'genre',
        'min_age_rating',
        'storage_req_gb',
    ];

    /**
     * The consoles where this game is installed (N:M relationship).
     */
    public function consoles(): BelongsToMany
    {
        return $this->belongsToMany(Console::class)
            ->withPivot('installed_at', 'storage_size_gb')
            ->withTimestamps();
    }
}
