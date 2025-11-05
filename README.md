# Support - Contact/Ticket Helpdesk for Bagisto v2.3.5

Drop‑in contact form and mini helpdesk for Bagisto v2.3.5. Turn inquiries into tickets with subjects, priorities, categories, assignees, internal/public notes, attachments, and SLAs. Support admins triage with filters, canned replies, bulk actions; customers get a token portal and email updates.

## Features

### Admin Features
- **Ticket Management**: Full CRUD operations for support tickets
- **Status Management**: Customizable ticket statuses (new, open, resolved, closed)
- **Priority Levels**: Configurable priorities (low, medium, high, urgent)
- **Categories**: Organize tickets by category
- **Assignees**: Assign tickets to team members
- **Watchers**: Add multiple watchers to tickets for notifications
- **Notes**: Internal and public notes with customer email notifications
- **Attachments**: File upload support for tickets and notes
- **Filters**: Advanced filtering by status, priority, category, assignee
- **Bulk Actions**: Perform actions on multiple tickets at once
- **Canned Responses**: Pre-defined responses for quick replies
- **SLA Management**: Automatic SLA due date calculation based on priority
- **Activity Log**: Track all changes and actions on tickets
- **Automation Rules**: Create rules to automate ticket handling
- **Slack Integration**: Get notifications in Slack channels

### Customer Features
- **Token Portal**: Secure token-based access to tickets (no login required)
- **Contact Form**: Easy-to-use contact form for submitting tickets
- **Email Notifications**: Automatic email updates on ticket status changes
- **Reply System**: Customers can reply to tickets via the portal

## Installation

### Step 1: Install via Composer

```bash
composer require kevinbharris/support
```

### Step 2: Publish Assets (Required)

Publish the package assets to display the custom ticket icon:

```bash
php artisan vendor:publish --tag=support-assets
```

The package will automatically inject the necessary CSS to display the custom ticket icon in the admin menu.

**Optional (for customization):**

```bash
php artisan vendor:publish --tag=support-config
php artisan vendor:publish --tag=support-views
```

### Step 3: Run Migrations

```bash
php artisan migrate
```

### Step 4: Create Default Statuses and Priorities

You can manually create statuses and priorities via the admin panel, or seed them programmatically:

```php
use KevinBHarris\Support\Models\Status;
use KevinBHarris\Support\Models\Priority;
use KevinBHarris\Support\Models\Category;

// Create default statuses
Status::create(['name' => 'New', 'code' => 'new', 'color' => '#3b82f6', 'sort_order' => 1]);
Status::create(['name' => 'Open', 'code' => 'open', 'color' => '#f59e0b', 'sort_order' => 2]);
Status::create(['name' => 'Resolved', 'code' => 'resolved', 'color' => '#10b981', 'sort_order' => 3]);
Status::create(['name' => 'Closed', 'code' => 'closed', 'color' => '#6b7280', 'sort_order' => 4]);

// Create default priorities
Priority::create(['name' => 'Low', 'code' => 'low', 'color' => '#6b7280', 'sort_order' => 1]);
Priority::create(['name' => 'Medium', 'code' => 'medium', 'color' => '#f59e0b', 'sort_order' => 2]);
Priority::create(['name' => 'High', 'code' => 'high', 'color' => '#ef4444', 'sort_order' => 3]);
Priority::create(['name' => 'Urgent', 'code' => 'urgent', 'color' => '#dc2626', 'sort_order' => 4]);

// Create default categories
Category::create(['name' => 'General', 'slug' => 'general', 'sort_order' => 1]);
Category::create(['name' => 'Technical', 'slug' => 'technical', 'sort_order' => 2]);
Category::create(['name' => 'Billing', 'slug' => 'billing', 'sort_order' => 3]);
```

## Configuration

The configuration file is located at `config/support.php` after publishing. Key configuration options:

### Email Configuration

```php
'email' => [
    'from_address' => env('SUPPORT_FROM_EMAIL', 'support@example.com'),
    'from_name' => env('SUPPORT_FROM_NAME', 'Support Team'),
],
```

Add to your `.env`:

```
SUPPORT_FROM_EMAIL=support@yourdomain.com
SUPPORT_FROM_NAME="Your Support Team"
```

### SLA Configuration

Configure SLA hours for each priority level:

```php
'sla' => [
    'low' => 72,      // 72 hours
    'medium' => 48,   // 48 hours
    'high' => 24,     // 24 hours
    'urgent' => 4,    // 4 hours
],
```

### Slack Integration

Enable Slack notifications:

```php
'slack' => [
    'enabled' => env('SUPPORT_SLACK_ENABLED', false),
    'webhook_url' => env('SUPPORT_SLACK_WEBHOOK_URL', ''),
    'channel' => env('SUPPORT_SLACK_CHANNEL', '#support'),
    'username' => env('SUPPORT_SLACK_USERNAME', 'Support Bot'),
],
```

Add to your `.env`:

```
SUPPORT_SLACK_ENABLED=true
SUPPORT_SLACK_WEBHOOK_URL=https://hooks.slack.com/services/YOUR/WEBHOOK/URL
SUPPORT_SLACK_CHANNEL=#support
SUPPORT_SLACK_USERNAME="Support Bot"
```

### Attachments Configuration

```php
'attachments' => [
    'max_size' => 10240, // KB
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt', 'zip'],
    'storage_path' => 'support/attachments',
],
```

## Usage

### Admin Routes

All admin routes are prefixed with `/admin/support`:

- `/admin/support/tickets` - List tickets
- `/admin/support/tickets/create` - Create new ticket
- `/admin/support/tickets/{id}` - View ticket details
- `/admin/support/tickets/{id}/edit` - Edit ticket
- `/admin/support/statuses` - Manage statuses
- `/admin/support/priorities` - Manage priorities
- `/admin/support/categories` - Manage categories
- `/admin/support/canned-responses` - Manage canned responses
- `/admin/support/rules` - Manage automation rules

### Customer Portal Routes

- `/support/contact` - Contact form for submitting new tickets
- `/support/ticket/{token}` - View and reply to ticket

### Creating Tickets Programmatically

```php
use KevinBHarris\Support\Models\Ticket;

$ticket = Ticket::create([
    'subject' => 'Need help with my order',
    'description' => 'I have a question about order #12345',
    'customer_name' => 'John Doe',
    'customer_email' => 'john@example.com',
    'status_id' => 1,
    'priority_id' => 2,
    'category_id' => 1,
]);

// Calculate SLA due date
$ticket->calculateSlaDue();
$ticket->save();
```

### Adding Notes

```php
use KevinBHarris\Support\Models\Note;

$note = Note::create([
    'ticket_id' => $ticket->id,
    'content' => 'We are looking into your issue.',
    'is_internal' => false, // false = customer can see, true = internal only
    'created_by' => auth()->id(),
    'created_by_name' => auth()->user()->name,
]);
```

### Adding Watchers

```php
use KevinBHarris\Support\Models\Watcher;

Watcher::create([
    'ticket_id' => $ticket->id,
    'email' => 'manager@example.com',
    'name' => 'Support Manager',
]);
```

### Creating Canned Responses

```php
use KevinBHarris\Support\Models\CannedResponse;

CannedResponse::create([
    'title' => 'Welcome Message',
    'shortcut' => '/welcome',
    'content' => 'Thank you for contacting us! We will get back to you soon.',
]);
```

### Creating Automation Rules

```php
use KevinBHarris\Support\Models\Rule;

Rule::create([
    'name' => 'Auto-assign urgent tickets',
    'description' => 'Automatically assign urgent tickets to senior support',
    'conditions' => [
        'field' => 'priority_id',
        'operator' => 'equals',
        'value' => 4, // Urgent priority ID
    ],
    'actions' => [
        'action' => 'assign',
        'value' => 1, // Senior support user ID
    ],
]);
```

## Events

The package fires the following events:

- `KevinBHarris\Support\Events\TicketCreated` - When a new ticket is created
- `KevinBHarris\Support\Events\TicketUpdated` - When a ticket is updated
- `KevinBHarris\Support\Events\NoteAdded` - When a note is added to a ticket

You can listen to these events in your application:

```php
// In EventServiceProvider
protected $listen = [
    \KevinBHarris\Support\Events\TicketCreated::class => [
        \App\Listeners\SendTicketNotification::class,
    ],
];
```

## Database Schema

The package creates the following tables:

- `support_statuses` - Ticket statuses
- `support_priorities` - Ticket priorities
- `support_categories` - Ticket categories
- `support_tickets` - Tickets
- `support_notes` - Ticket notes/replies
- `support_attachments` - File attachments
- `support_watchers` - Ticket watchers
- `support_canned_responses` - Canned responses
- `support_activity_logs` - Activity logs
- `support_rules` - Automation rules

## Requirements

- PHP 8.1 or higher
- Laravel 10.x
- Bagisto 2.3.5
- MySQL 5.7+ or PostgreSQL

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For support, please open an issue on the GitHub repository or contact support@example.com.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.
