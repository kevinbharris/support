<?php

namespace KevinBHarris\Support\Mail;

use KevinBHarris\Support\Models\Note;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoteAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Note $note;

    /**
     * Create a new message instance.
     */
    public function __construct(Note $note)
    {
        $this->note = $note;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $ticket = $this->note->ticket;
        
        return $this->from(
            config('support.email.from_address'),
            config('support.email.from_name')
        )
        ->subject("New Reply on Ticket: {$ticket->ticket_number}")
        ->markdown('support::emails.note-added');
    }
}
