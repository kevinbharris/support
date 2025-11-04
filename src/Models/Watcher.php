<?php

namespace KevinBHarris\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Watcher extends Model
{
    protected $table = 'support_watchers';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'email',
        'name',
    ];

    /**
     * Get the ticket that owns this watcher.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
