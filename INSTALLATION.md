# Installation Guide

This guide will walk you through installing and configuring the kevinbharris/support package in your **Bagisto v2.3.8** application.

---

## Prerequisites

- **PHP 8.1 or higher**
- **Laravel 11.x**
- **Bagisto 2.3.8**
- **MySQL 5.7+ or PostgreSQL**
- **Composer (v2 recommended)**

> ⚠️ **Tip:** Make sure your project is using Bagisto 2.3.8 before installing!

---

## Step-by-Step Installation

### 1. Install the Package

In your Bagisto app directory, run:

```bash
composer require kevinbharris/support
```

---

### 2. Publish Configuration, Views, and Assets

#### Publish config

```bash
php artisan vendor:publish --tag=support-config
```
> This creates `config/support.php` for customizing helpdesk settings.

#### Publish views

```bash
php artisan vendor:publish --tag=support-views
```
> This copies views to `resources/views/vendor/support` if you want to override them.

#### Publish assets (required for icons and styles!)

```bash
php artisan vendor:publish --tag=support-assets
```
> This copies fonts, CSS, and images to `public/vendor/support/`.

---

### 3. Configure Environment Variables

Add to your `.env` file (update with your settings):

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

---

### 4. Run Migrations

Run migrations to create the required support tables:

```bash
php artisan migrate
```

Tables created:
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

---

### 5. Seed Initial Data

To seed default statuses, priorities, and categories:

#### Option A: Use the Admin Panel
Go to Support → Statuses/Priorities/Categories, and add entries.

#### Option B: Use Tinker

```php
use KevinBHarris\Support\Models\Status;
use KevinBHarris\Support\Models\Priority;
use KevinBHarris\Support\Models\Category;

// Statuses
Status::create(['name'=>'New','code'=>'new','color'=>'#3b82f6','sort_order'=>1,'is_active'=>true]);
Status::create(['name'=>'Open','code'=>'open','color'=>'#f59e0b','sort_order'=>2,'is_active'=>true]);
Status::create(['name'=>'Resolved','code'=>'resolved','color'=>'#10b981','sort_order'=>3,'is_active'=>true]);
Status::create(['name'=>'Closed','code'=>'closed','color'=>'#6b7280','sort_order'=>4,'is_active'=>true]);

// Priorities
Priority::create(['name'=>'Low','code'=>'low','color'=>'#6b7280','sort_order'=>1,'is_active'=>true]);
Priority::create(['name'=>'Medium','code'=>'medium','color'=>'#f59e0b','sort_order'=>2,'is_active'=>true]);
Priority::create(['name'=>'High','code'=>'high','color'=>'#ef4444','sort_order'=>3,'is_active'=>true]);
Priority::create(['name'=>'Urgent','code'=>'urgent','color'=>'#dc2626','sort_order'=>4,'is_active'=>true]);

// Categories
Category::create(['name'=>'General Inquiry','slug'=>'general','sort_order'=>1,'is_active'=>true]);
Category::create(['name'=>'Technical Support','slug'=>'technical','sort_order'=>2,'is_active'=>true]);
Category::create(['name'=>'Billing Question','slug'=>'billing','sort_order'=>3,'is_active'=>true]);
Category::create(['name'=>'Product Question','slug'=>'product','sort_order'=>4,'is_active'=>true]);
```

#### Option C: Use a Seeder
See example in the file for `SupportSeeder.php`, then run:

```bash
php artisan db:seed --class=SupportSeeder
```

---

### 6. Link Storage (for Attachments)

```bash
php artisan storage:link
```
> Ensures attachments are served publicly.

---

### 7. Configure Email

In `.env`, update mail settings for notifications:

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

---

### 8. Access the Admin Panel

Visit:

- `/admin/support/tickets`
- `/admin/support/statuses`
- `/admin/support/priorities`
- `/admin/support/categories`
- `/admin/support/canned-responses`
- `/admin/support/rules`

---

### 9. Test the Customer Portal

Accessible at:

- Contact form: `https://yourdomain.com/support/contact`
- Ticket view: `https://yourdomain.com/support/ticket/{token}`

---

## Optional: Enable Slack Notifications

1. Create a Slack App and add an Incoming Webhook
2. Copy your webhook URL
3. Add to your `.env`:

```env
SUPPORT_SLACK_ENABLED=true
SUPPORT_SLACK_WEBHOOK_URL=https://hooks.slack.com/services/YOUR/WEBHOOK/URL
SUPPORT_SLACK_CHANNEL=#support
```

---

## Troubleshooting

### Routes not found?
Clear route cache:
```bash
php artisan route:clear
php artisan route:cache
```

### Views not rendering?
Clear view cache:
```bash
php artisan view:clear
```

### Email not sending?
- Check `.env` mail settings
- Check logs: `storage/logs/laravel.log`
- Test mail: `php artisan tinker` & send a dummy email

### Migrations fail?
- Check DB connection
- If tables exist: `php artisan migrate:status`
- Rollback if needed:
```bash
php artisan migrate:rollback --step=1
```

---

## Next Steps

1. Create your first ticket via the admin panel
2. Test the customer portal (submit a contact form)
3. Try canned responses and automation rules
4. Customize views as desired

---

## Support

- GitHub Issues: [https://github.com/kevinbharris/support](https://github.com/kevinbharris/support/issues)
- Email: kevin.b.harris.2015@gmail.com

---

## Upgrading

When a new version is released:

```bash
composer update kevinbharris/support
php artisan migrate
```

> **Always back up your database before upgrading!**
