<?php

namespace KevinBHarris\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Ticket extends Model
{
    protected $table = 'support_tickets';

    protected $fillable = [
        'ticket_number',
        'subject',
        'description',
        'status_id',
        'priority_id',
        'category_id',
        'customer_id',
        'customer_name',
        'customer_email',
        'assigned_to',
        'access_token',
        'first_response_at',
        'resolved_at',
        'closed_at',
        'sla_due_at',
    ];

    protected $casts = [
        'first_response_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
        'sla_due_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = 'TKT-' . strtoupper(Str::random(8));
            }
            if (empty($ticket->access_token)) {
                $ticket->access_token = Str::random(64);
            }
        });
    }

    /**
     * Get the status for this ticket.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    /**
     * Get the priority for this ticket.
     */
    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    /**
     * Get the category for this ticket.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the notes for this ticket.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'ticket_id');
    }

    /**
     * Get the attachments for this ticket.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * Get the watchers for this ticket.
     */
    public function watchers(): HasMany
    {
        return $this->hasMany(Watcher::class, 'ticket_id');
    }

    /**
     * Get the activity logs for this ticket.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'ticket_id');
    }

    /**
     * Check if ticket is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->sla_due_at && now()->isAfter($this->sla_due_at);
    }

    /**
     * Calculate and set SLA due date.
     */
    public function calculateSlaDue(): void
    {
        if ($this->priority) {
            $slaHours = config("support.sla.{$this->priority->code}", 24);
            $this->sla_due_at = now()->addHours($slaHours);
        }
    }
}
