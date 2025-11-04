<?php

namespace KevinBHarris\Support\Listeners;

use KevinBHarris\Support\Events\TicketUpdated;
use KevinBHarris\Support\Mail\TicketUpdatedMail;
use KevinBHarris\Support\Services\SlackService;
use Illuminate\Support\Facades\Mail;

class SendTicketUpdatedNotification
{
    /**
     * Handle the event.
     */
    public function handle(TicketUpdated $event): void
    {
        $ticket = $event->ticket;

        // Send email to customer
        Mail::to($ticket->customer_email)
            ->send(new TicketUpdatedMail($ticket, $event->changes));

        // Send to watchers
        foreach ($ticket->watchers as $watcher) {
            Mail::to($watcher->email)
                ->send(new TicketUpdatedMail($ticket, $event->changes));
        }

        // Send Slack notification
        if (config('support.slack.enabled')) {
            app(SlackService::class)->notifyTicketUpdated($ticket, $event->changes);
        }
    }
}
