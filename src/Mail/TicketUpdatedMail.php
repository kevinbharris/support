<?php

namespace KevinBHarris\Support\Mail;

use KevinBHarris\Support\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public array $changes;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket, array $changes = [])
    {
        $this->ticket = $ticket;
        $this->changes = $changes;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from(
            config('support.email.from_address'),
            config('support.email.from_name')
        )
        ->subject("Ticket Updated: {$this->ticket->ticket_number}")
        ->markdown('support::emails.ticket-updated');
    }
}
