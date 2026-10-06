<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_code',
        'room_id',
        'tenant_id',
        'title',
        'description',
        'priority',
        'status',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the room for this maintenance ticket (Inverse 1:N relationship).
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the tenant that filed this maintenance ticket (Inverse 1:N relationship).
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }
}
