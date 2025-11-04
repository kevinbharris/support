<?php

namespace KevinBHarris\Support\Mail;

use KevinBHarris\Support\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
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
        ->subject("Ticket Created: {$this->ticket->ticket_number}")
        ->markdown('support::emails.ticket-created');
    }
}
