<?php

namespace KevinBHarris\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'support_activity_logs';

    protected $fillable = [
        'ticket_id',
        'action',
        'description',
        'properties',
        'user_id',
        'user_name',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Get the ticket that owns this activity log.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
