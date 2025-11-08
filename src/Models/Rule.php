<?php

namespace KevinBHarris\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rule extends Model
{
    protected $table = 'support_rules';

    protected $fillable = [
        'name',
        'description',
        'from_status_id',
        'to_status_id',
        'after_hours',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'after_hours' => 'integer',
    ];

    /**
     * Get the from status for this rule.
     */
    public function fromStatus(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'from_status_id');
    }

    /**
     * Get the to status for this rule.
     */
    public function toStatus(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'to_status_id');
    }
}
