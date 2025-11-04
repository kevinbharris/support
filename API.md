# API Reference

This document provides a quick reference for the main classes and methods in the Support package.

## Models

### Ticket

**Namespace:** `KevinBHarris\Support\Models\Ticket`

**Properties:**
- `ticket_number` (string) - Unique ticket identifier
- `subject` (string) - Ticket subject
- `description` (text) - Ticket description
- `status_id` (int) - Foreign key to Status
- `priority_id` (int) - Foreign key to Priority
- `category_id` (int) - Foreign key to Category
- `customer_name` (string) - Customer name
- `customer_email` (string) - Customer email
- `assigned_to` (int) - User ID of assignee
- `access_token` (string) - Token for portal access
- `first_response_at` (datetime) - First response timestamp
- `resolved_at` (datetime) - Resolution timestamp
- `closed_at` (datetime) - Closure timestamp
- `sla_due_at` (datetime) - SLA due date

**Relationships:**
- `status()` - BelongsTo Status
- `priority()` - BelongsTo Priority
- `category()` - BelongsTo Category
- `notes()` - HasMany Note
- `attachments()` - MorphMany Attachment
- `watchers()` - HasMany Watcher
- `activityLogs()` - HasMany ActivityLog

**Methods:**
- `isOverdue(): bool` - Check if ticket is past SLA
- `calculateSlaDue(): void` - Calculate and set SLA due date

**Example:**
```php
$ticket = Ticket::create([
    'subject' => 'Help needed',
    'description' => 'I need assistance',
    'customer_name' => 'John Doe',
    'customer_email' => 'john@example.com',
    'status_id' => 1,
    'priority_id' => 2,
    'category_id' => 1,
]);

$ticket->calculateSlaDue();
$ticket->save();

if ($ticket->isOverdue()) {
    // Handle overdue ticket
}
```

### Status

**Namespace:** `KevinBHarris\Support\Models\Status`

**Properties:**
- `name` (string) - Status name
- `code` (string) - Unique status code
- `color` (string) - Color hex code
- `sort_order` (int) - Display order
- `is_active` (bool) - Active flag

**Example:**
```php
$status = Status::create([
    'name' => 'In Progress',
    'code' => 'in_progress',
    'color' => '#3b82f6',
    'sort_order' => 5,
]);
```

### Priority

**Namespace:** `KevinBHarris\Support\Models\Priority`

**Properties:**
- `name` (string) - Priority name
- `code` (string) - Unique priority code
- `color` (string) - Color hex code
- `sort_order` (int) - Display order
- `is_active` (bool) - Active flag

### Category

**Namespace:** `KevinBHarris\Support\Models\Category`

**Properties:**
- `name` (string) - Category name
- `slug` (string) - Unique slug
- `description` (text) - Category description
- `sort_order` (int) - Display order
- `is_active` (bool) - Active flag

### Note

**Namespace:** `KevinBHarris\Support\Models\Note`

**Properties:**
- `ticket_id` (int) - Foreign key to Ticket
- `content` (text) - Note content
- `is_internal` (bool) - Internal note flag
- `created_by` (int) - User ID of creator
- `created_by_name` (string) - Creator name

**Relationships:**
- `ticket()` - BelongsTo Ticket
- `attachments()` - MorphMany Attachment

**Example:**
```php
$note = Note::create([
    'ticket_id' => $ticket->id,
    'content' => 'We are working on your issue',
    'is_internal' => false,
    'created_by' => auth()->id(),
    'created_by_name' => auth()->user()->name,
]);
```

### Attachment

**Namespace:** `KevinBHarris\Support\Models\Attachment`

**Properties:**
- `attachable_type` (string) - Polymorphic type
- `attachable_id` (int) - Polymorphic ID
- `name` (string) - Original filename
- `filename` (string) - Stored filename
- `mime_type` (string) - MIME type
- `size` (int) - File size in bytes
- `path` (string) - Storage path

**Relationships:**
- `attachable()` - MorphTo (Ticket or Note)

### Watcher

**Namespace:** `KevinBHarris\Support\Models\Watcher`

**Properties:**
- `ticket_id` (int) - Foreign key to Ticket
- `user_id` (int) - User ID (nullable)
- `email` (string) - Watcher email
- `name` (string) - Watcher name

**Example:**
```php
$watcher = Watcher::create([
    'ticket_id' => $ticket->id,
    'email' => 'manager@example.com',
    'name' => 'Support Manager',
]);
```

### CannedResponse

**Namespace:** `KevinBHarris\Support\Models\CannedResponse`

**Properties:**
- `title` (string) - Response title
- `shortcut` (string) - Unique shortcut code
- `content` (text) - Response content
- `is_active` (bool) - Active flag

**Example:**
```php
$response = CannedResponse::create([
    'title' => 'Welcome Message',
    'shortcut' => '/welcome',
    'content' => 'Thank you for contacting us!',
]);
```

### ActivityLog

**Namespace:** `KevinBHarris\Support\Models\ActivityLog`

**Properties:**
- `ticket_id` (int) - Foreign key to Ticket
- `action` (string) - Action type
- `description` (text) - Action description
- `properties` (json) - Additional properties
- `user_id` (int) - User ID
- `user_name` (string) - User name

**Example:**
```php
ActivityLog::create([
    'ticket_id' => $ticket->id,
    'action' => 'status_changed',
    'description' => 'Status changed from New to Open',
    'properties' => ['old' => 'New', 'new' => 'Open'],
    'user_id' => auth()->id(),
    'user_name' => auth()->user()->name,
]);
```

### Rule

**Namespace:** `KevinBHarris\Support\Models\Rule`

**Properties:**
- `name` (string) - Rule name
- `description` (text) - Rule description
- `conditions` (json) - Rule conditions
- `actions` (json) - Rule actions
- `sort_order` (int) - Execution order
- `is_active` (bool) - Active flag

## Events

### TicketCreated

**Namespace:** `KevinBHarris\Support\Events\TicketCreated`

**Properties:**
- `ticket` (Ticket) - The created ticket

**Example:**
```php
event(new TicketCreated($ticket));
```

### TicketUpdated

**Namespace:** `KevinBHarris\Support\Events\TicketUpdated`

**Properties:**
- `ticket` (Ticket) - The updated ticket
- `changes` (array) - Array of changes

**Example:**
```php
event(new TicketUpdated($ticket, ['status' => 'Open']));
```

### NoteAdded

**Namespace:** `KevinBHarris\Support\Events\NoteAdded`

**Properties:**
- `note` (Note) - The added note

**Example:**
```php
event(new NoteAdded($note));
```

## Services

### SlackService

**Namespace:** `KevinBHarris\Support\Services\SlackService`

**Methods:**
- `notifyTicketCreated(Ticket $ticket): void` - Send Slack notification for new ticket
- `notifyTicketUpdated(Ticket $ticket, array $changes): void` - Send Slack notification for ticket update

**Example:**
```php
$slackService = app(SlackService::class);
$slackService->notifyTicketCreated($ticket);
```

## Configuration

### Config Keys

Access configuration using Laravel's `config()` helper:

```php
// Email settings
config('support.email.from_address');
config('support.email.from_name');

// SLA settings
config('support.sla.low');    // 72 hours
config('support.sla.medium'); // 48 hours
config('support.sla.high');   // 24 hours
config('support.sla.urgent'); // 4 hours

// Slack settings
config('support.slack.enabled');
config('support.slack.webhook_url');
config('support.slack.channel');

// Attachment settings
config('support.attachments.max_size');
config('support.attachments.allowed_extensions');
config('support.attachments.storage_path');
```

## Routes

### Admin Routes

All admin routes are protected by `['web', 'admin']` middleware:

- `GET /admin/support/tickets` - List tickets
- `GET /admin/support/tickets/create` - Create ticket form
- `POST /admin/support/tickets` - Store ticket
- `GET /admin/support/tickets/{id}` - View ticket
- `GET /admin/support/tickets/{id}/edit` - Edit ticket form
- `PUT /admin/support/tickets/{id}` - Update ticket
- `DELETE /admin/support/tickets/{id}` - Delete ticket
- `POST /admin/support/tickets/{id}/notes` - Add note
- `POST /admin/support/tickets/bulk` - Bulk actions

Similar CRUD routes exist for:
- `/admin/support/statuses`
- `/admin/support/priorities`
- `/admin/support/categories`
- `/admin/support/canned-responses`
- `/admin/support/rules`

### Portal Routes

Public routes protected by `['web']` middleware:

- `GET /support/contact` - Contact form
- `POST /support/contact` - Submit ticket
- `GET /support/ticket/{token}` - View ticket
- `POST /support/ticket/{token}/reply` - Reply to ticket

## Helper Methods

### Query Scopes

Add custom scopes to models:

```php
// In Ticket model
public function scopeOverdue($query)
{
    return $query->whereNotNull('sla_due_at')
                 ->where('sla_due_at', '<', now());
}

// Usage
$overdueTickets = Ticket::overdue()->get();
```

### Accessors

```php
// In Ticket model
public function getIsOverdueAttribute(): bool
{
    return $this->isOverdue();
}

// Usage
if ($ticket->is_overdue) {
    // Handle overdue
}
```

## Mail Templates

Customize mail templates by publishing views and editing:

- `resources/views/vendor/support/emails/ticket-created.blade.php`
- `resources/views/vendor/support/emails/ticket-updated.blade.php`
- `resources/views/vendor/support/emails/note-added.blade.php`

## View Components

All views extend `admin::layouts.master` for admin views and use standalone HTML for portal views.

You can override views by publishing them and editing in:
`resources/views/vendor/support/`
