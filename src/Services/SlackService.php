<?php

namespace KevinBHarris\Support\Services;

use KevinBHarris\Support\Models\Ticket;
use Illuminate\Support\Facades\Http;

class SlackService
{
    /**
     * Notify Slack about a new ticket.
     */
    public function notifyTicketCreated(Ticket $ticket): void
    {
        if (!config('support.slack.enabled')) {
            return;
        }

        $webhookUrl = config('support.slack.webhook_url');
        
        if (empty($webhookUrl)) {
            return;
        }

        $message = [
            'channel' => config('support.slack.channel'),
            'username' => config('support.slack.username'),
            'text' => "🎫 New Ticket Created",
            'attachments' => [
                [
                    'color' => 'good',
                    'fields' => [
                        [
                            'title' => 'Ticket Number',
                            'value' => $ticket->ticket_number,
                            'short' => true,
                        ],
                        [
                            'title' => 'Subject',
                            'value' => $ticket->subject,
                            'short' => true,
                        ],
                        [
                            'title' => 'Priority',
                            'value' => $ticket->priority->name,
                            'short' => true,
                        ],
                        [
                            'title' => 'Status',
                            'value' => $ticket->status->name,
                            'short' => true,
                        ],
                        [
                            'title' => 'Customer',
                            'value' => "{$ticket->customer_name} ({$ticket->customer_email})",
                            'short' => false,
                        ],
                    ],
                ],
            ],
        ];

        Http::post($webhookUrl, $message);
    }

    /**
     * Notify Slack about a ticket update.
     */
    public function notifyTicketUpdated(Ticket $ticket, array $changes): void
    {
        if (!config('support.slack.enabled')) {
            return;
        }

        $webhookUrl = config('support.slack.webhook_url');
        
        if (empty($webhookUrl)) {
            return;
        }

        $changeText = $this->formatChanges($changes);

        $message = [
            'channel' => config('support.slack.channel'),
            'username' => config('support.slack.username'),
            'text' => "🔔 Ticket Updated: {$ticket->ticket_number}",
            'attachments' => [
                [
                    'color' => 'warning',
                    'fields' => [
                        [
                            'title' => 'Changes',
                            'value' => $changeText,
                            'short' => false,
                        ],
                    ],
                ],
            ],
        ];

        Http::post($webhookUrl, $message);
    }

    /**
     * Format changes array into readable text.
     */
    protected function formatChanges(array $changes): string
    {
        $formatted = [];
        
        foreach ($changes as $key => $value) {
            $formatted[] = "• {$key}: {$value}";
        }
        
        return implode("\n", $formatted);
    }
}
