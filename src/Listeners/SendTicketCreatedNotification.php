<?php

namespace KevinBHarris\Support\Listeners;

use KevinBHarris\Support\Events\TicketCreated;
use KevinBHarris\Support\Mail\TicketCreatedMail;
use KevinBHarris\Support\Services\SlackService;
use Illuminate\Support\Facades\Mail;

class SendTicketCreatedNotification
{
    /**
     * Handle the event.
     */
    public function handle(TicketCreated $event): void
    {
        $ticket = $event->ticket;

        // Send email to customer
        Mail::to($ticket->customer_email)
            ->send(new TicketCreatedMail($ticket));

        // Send to watchers
        foreach ($ticket->watchers as $watcher) {
            Mail::to($watcher->email)
                ->send(new TicketCreatedMail($ticket));
        }

        // Send Slack notification
        if (config('support.slack.enabled')) {
            app(SlackService::class)->notifyTicketCreated($ticket);
        }
    }
}
