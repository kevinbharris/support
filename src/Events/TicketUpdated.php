<?php

namespace KevinBHarris\Support\Events;

use KevinBHarris\Support\Models\Ticket;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketUpdated
{
    use Dispatchable, SerializesModels;

    public Ticket $ticket;
    public array $changes;

    /**
     * Create a new event instance.
     */
    public function __construct(Ticket $ticket, array $changes = [])
    {
        $this->ticket = $ticket;
        $this->changes = $changes;
    }
}
