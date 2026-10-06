<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'console_id',
        'service_date',
        'technician_name',
        'cost',
        'issue_description',
        'action_taken',
    ];

    protected $casts = [
        'service_date' => 'date',
    ];

    /**
     * Get the console associated with this maintenance record (Inverse 1:N relationship).
     */
    public function console(): BelongsTo
    {
        return $this->belongsTo(Console::class);
    }
}
