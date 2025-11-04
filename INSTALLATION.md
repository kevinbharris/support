# Installation Guide

This guide will walk you through installing and configuring the kevinbharris/support package in your Bagisto v2.3.5 application.

## Prerequisites

- PHP 8.1 or higher
- Laravel 10.x
- Bagisto 2.3.5
- MySQL 5.7+ or PostgreSQL
- Composer

## Step-by-Step Installation

### 1. Install the Package

Add the package to your Bagisto application using Composer:

```bash
cd /path/to/your/bagisto
composer require kevinbharris/support
```

### 2. Publish Configuration and Views

Publish the package configuration file (optional but recommended):

```bash
php artisan vendor:publish --tag=support-config
```

This will create `config/support.php` where you can customize settings.

Publish views if you want to customize them (optional):

```bash
php artisan vendor:publish --tag=support-views
```

This will copy views to `resources/views/vendor/support/`.

### 3. Configure Environment Variables

Add the following to your `.env` file:

```env
# Support Email Configuration
SUPPORT_FROM_EMAIL=support@yourdomain.com
SUPPORT_FROM_NAME="Your Support Team"

# Slack Integration (Optional)
SUPPORT_SLACK_ENABLED=false
SUPPORT_SLACK_WEBHOOK_URL=
SUPPORT_SLACK_CHANNEL=#support
SUPPORT_SLACK_USERNAME="Support Bot"
```

### 4. Run Migrations

Execute the database migrations to create the required tables:

```bash
php artisan migrate
```

This will create the following tables:
- support_statuses
- support_priorities
- support_categories
- support_tickets
- support_notes
- support_attachments
- support_watchers
- support_canned_responses
- support_activity_logs
- support_rules

### 5. Seed Initial Data

Create default statuses, priorities, and categories. You can do this via the admin panel or run the following in `php artisan tinker`:

```php
use KevinBHarris\Support\Models\Status;
use KevinBHarris\Support\Models\Priority;
use KevinBHarris\Support\Models\Category;

// Create statuses
Status::create(['name' => 'New', 'code' => 'new', 'color' => '#3b82f6', 'sort_order' => 1, 'is_active' => true]);
Status::create(['name' => 'Open', 'code' => 'open', 'color' => '#f59e0b', 'sort_order' => 2, 'is_active' => true]);
Status::create(['name' => 'Resolved', 'code' => 'resolved', 'color' => '#10b981', 'sort_order' => 3, 'is_active' => true]);
Status::create(['name' => 'Closed', 'code' => 'closed', 'color' => '#6b7280', 'sort_order' => 4, 'is_active' => true]);

// Create priorities
Priority::create(['name' => 'Low', 'code' => 'low', 'color' => '#6b7280', 'sort_order' => 1, 'is_active' => true]);
Priority::create(['name' => 'Medium', 'code' => 'medium', 'color' => '#f59e0b', 'sort_order' => 2, 'is_active' => true]);
Priority::create(['name' => 'High', 'code' => 'high', 'color' => '#ef4444', 'sort_order' => 3, 'is_active' => true]);
Priority::create(['name' => 'Urgent', 'code' => 'urgent', 'color' => '#dc2626', 'sort_order' => 4, 'is_active' => true]);

// Create categories
Category::create(['name' => 'General Inquiry', 'slug' => 'general', 'sort_order' => 1, 'is_active' => true]);
Category::create(['name' => 'Technical Support', 'slug' => 'technical', 'sort_order' => 2, 'is_active' => true]);
Category::create(['name' => 'Billing Question', 'slug' => 'billing', 'sort_order' => 3, 'is_active' => true]);
Category::create(['name' => 'Product Question', 'slug' => 'product', 'sort_order' => 4, 'is_active' => true]);
```

Or create a seeder file:

```php
// database/seeders/SupportSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use KevinBHarris\Support\Models\Status;
use KevinBHarris\Support\Models\Priority;
use KevinBHarris\Support\Models\Category;

class SupportSeeder extends Seeder
{
    public function run()
    {
        // Statuses
        $statuses = [
            ['name' => 'New', 'code' => 'new', 'color' => '#3b82f6', 'sort_order' => 1],
            ['name' => 'Open', 'code' => 'open', 'color' => '#f59e0b', 'sort_order' => 2],
            ['name' => 'Resolved', 'code' => 'resolved', 'color' => '#10b981', 'sort_order' => 3],
            ['name' => 'Closed', 'code' => 'closed', 'color' => '#6b7280', 'sort_order' => 4],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }

        // Priorities
        $priorities = [
            ['name' => 'Low', 'code' => 'low', 'color' => '#6b7280', 'sort_order' => 1],
            ['name' => 'Medium', 'code' => 'medium', 'color' => '#f59e0b', 'sort_order' => 2],
            ['name' => 'High', 'code' => 'high', 'color' => '#ef4444', 'sort_order' => 3],
            ['name' => 'Urgent', 'code' => 'urgent', 'color' => '#dc2626', 'sort_order' => 4],
        ];

        foreach ($priorities as $priority) {
            Priority::create($priority);
        }

        // Categories
        $categories = [
            ['name' => 'General Inquiry', 'slug' => 'general', 'sort_order' => 1],
            ['name' => 'Technical Support', 'slug' => 'technical', 'sort_order' => 2],
            ['name' => 'Billing Question', 'slug' => 'billing', 'sort_order' => 3],
            ['name' => 'Product Question', 'slug' => 'product', 'sort_order' => 4],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
```

Then run:

```bash
php artisan db:seed --class=SupportSeeder
```

### 6. Configure Storage (For Attachments)

Make sure your storage is properly linked:

```bash
php artisan storage:link
```

### 7. Configure Mail

Ensure your mail configuration in `.env` is set up correctly:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=support@yourdomain.com
MAIL_FROM_NAME="${APP_NAME} Support"
```

### 8. Access the Admin Panel

Navigate to your admin panel and access the support sections:

- Tickets: `/admin/support/tickets`
- Statuses: `/admin/support/statuses`
- Priorities: `/admin/support/priorities`
- Categories: `/admin/support/categories`
- Canned Responses: `/admin/support/canned-responses`
- Rules: `/admin/support/rules`

### 9. Add to Navigation (Optional)

Add links to your Bagisto admin navigation by editing your admin menu configuration or blade layouts:

```blade
<li>
    <a href="{{ route('admin.support.tickets.index') }}">
        <i class="icon-support"></i>
        <span>Support Tickets</span>
    </a>
</li>
```

### 10. Test the Portal

The customer portal is accessible at:

- Contact form: `https://yourdomain.com/support/contact`
- Ticket view: `https://yourdomain.com/support/ticket/{token}`

## Optional: Slack Integration

To enable Slack notifications:

1. Create a Slack App and add an Incoming Webhook
2. Copy the webhook URL
3. Update your `.env`:

```env
SUPPORT_SLACK_ENABLED=true
SUPPORT_SLACK_WEBHOOK_URL=https://hooks.slack.com/services/YOUR/WEBHOOK/URL
SUPPORT_SLACK_CHANNEL=#support
```

## Troubleshooting

### Issue: Routes not found

**Solution:** Clear your route cache:
```bash
php artisan route:clear
php artisan route:cache
```

### Issue: Views not rendering

**Solution:** Clear your view cache:
```bash
php artisan view:clear
```

### Issue: Email notifications not sending

**Solution:** 
1. Check your mail configuration in `.env`
2. Check Laravel logs: `storage/logs/laravel.log`
3. Test mail with: `php artisan tinker` and try sending a test email

### Issue: Migrations fail

**Solution:**
1. Ensure your database connection is properly configured
2. Check if tables already exist: `php artisan migrate:status`
3. Rollback if needed: `php artisan migrate:rollback --step=1`

## Next Steps

1. Create your first ticket via the admin panel
2. Test the customer portal by submitting a contact form
3. Configure canned responses for quick replies
4. Set up automation rules to streamline ticket handling
5. Customize views to match your brand

## Support

For issues or questions, please visit:
- GitHub: https://github.com/kevinbharris/support
- Email: support@example.com

## Upgrading

When a new version is released, update via Composer:

```bash
composer update kevinbharris/support
php artisan migrate
```

Always backup your database before upgrading!
