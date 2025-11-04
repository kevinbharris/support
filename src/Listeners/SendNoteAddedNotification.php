<?php

namespace KevinBHarris\Support\Listeners;

use KevinBHarris\Support\Events\NoteAdded;
use KevinBHarris\Support\Mail\NoteAddedMail;
use Illuminate\Support\Facades\Mail;

class SendNoteAddedNotification
{
    /**
     * Handle the event.
     */
    public function handle(NoteAdded $event): void
    {
        $note = $event->note;
        $ticket = $note->ticket;

        // Don't send notifications for internal notes
        if ($note->is_internal) {
            return;
        }

        // Send email to customer
        Mail::to($ticket->customer_email)
            ->send(new NoteAddedMail($note));

        // Send to watchers
        foreach ($ticket->watchers as $watcher) {
            Mail::to($watcher->email)
                ->send(new NoteAddedMail($note));
        }
    }
}
