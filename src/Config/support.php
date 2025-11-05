<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Ticket Statuses
    |--------------------------------------------------------------------------
    */
    'default_statuses' => [
        'new' => 'New',
        'open' => 'Open',
        'resolved' => 'Resolved',
        'closed' => 'Closed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Ticket Priorities
    |--------------------------------------------------------------------------
    */
    'default_priorities' => [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'urgent' => 'Urgent',
    ],

    /*
    |--------------------------------------------------------------------------
    | SLA Configuration (in hours)
    |--------------------------------------------------------------------------
    */
    'sla' => [
        'low' => 72,
        'medium' => 48,
        'high' => 24,
        'urgent' => 4,
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Configuration
    |--------------------------------------------------------------------------
    */
    'email' => [
        'from_address' => env('SUPPORT_FROM_EMAIL', 'support@example.com'),
        'from_name' => env('SUPPORT_FROM_NAME', 'Support Team'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Slack Webhook Configuration
    |--------------------------------------------------------------------------
    */
    'slack' => [
        'enabled' => env('SUPPORT_SLACK_ENABLED', false),
        'webhook_url' => env('SUPPORT_SLACK_WEBHOOK_URL', ''),
        'channel' => env('SUPPORT_SLACK_CHANNEL', '#support'),
        'username' => env('SUPPORT_SLACK_USERNAME', 'Support Bot'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Attachment Configuration
    |--------------------------------------------------------------------------
    */
    'attachments' => [
        'max_size' => 10240, // KB
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt', 'zip'],
        'storage_path' => 'support/attachments',
    ],

    /*
    |--------------------------------------------------------------------------
    | Portal Configuration
    |--------------------------------------------------------------------------
    */
    'portal' => [
        'token_expiry_days' => 30,
        'allow_guest_tickets' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | ReCaptcha Configuration
    |--------------------------------------------------------------------------
    */
    'recaptcha_enabled' => env('SUPPORT_RECAPTCHA_ENABLED', false),
    'recaptcha_site_key' => env('SUPPORT_RECAPTCHA_SITE_KEY', ''),
    'recaptcha_secret_key' => env('SUPPORT_RECAPTCHA_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Rules Configuration
    |--------------------------------------------------------------------------
    */
    'rules' => [
        'enabled' => true,
        'auto_assign_enabled' => true,
    ],
];
