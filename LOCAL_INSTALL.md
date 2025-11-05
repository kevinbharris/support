# Local Install Guide for Bagisto Extension (`kevinbharris/support`)

Install and configure the Support Helpdesk extension for Bagisto v2.3.8 (Laravel 11) locally.

---

## Prerequisites

- **PHP:** 8.1+
- **Laravel:** 11.x
- **Bagisto:** 2.3.8
- **Composer**

---

## Installation Steps

### 1. Start with Bagisto 2.3.8

Use an existing Bagisto v2.3.8 app, or install one:

```bash
composer create-project bagisto/bagisto:^2.3.8 bagisto
cd bagisto
```

### 2. Require the Support Extension

```bash
composer require kevinbharris/support
```

### 3. Publish Package Resources

Publish the configuration file (optional, recommended):

```bash
php artisan vendor:publish --tag=support-config
```

Publish views if you plan to customize:

```bash
php artisan vendor:publish --tag=support-views
```

### 4. Prepare Your Environment

Add these entries to your `.env` file, then edit as needed:

```env
SUPPORT_FROM_EMAIL=support@yourdomain.com
SUPPORT_FROM_NAME="Your Support Team"
# Slack Integration (Optional)
SUPPORT_SLACK_ENABLED=false
SUPPORT_SLACK_WEBHOOK_URL=
SUPPORT_SLACK_CHANNEL=#support
SUPPORT_SLACK_USERNAME="Support Bot"
```

### 5. Run Migrations

```bash
php artisan migrate
```
Creates all required support tables.

### 6. Seed Default Data

You can seed via the admin panel, or run in tinker:

```php
use KevinBHarris\Support\Models\Status;
use KevinBHarris\Support\Models\Priority;
use KevinBHarris\Support\Models\Category;

Status::create(['name' => 'New', 'code' => 'new', 'color' => '#3b82f6', 'sort_order' => 1, 'is_active' => true]);
Status::create(['name' => 'Open', 'code' => 'open', 'color' => '#f59e0b', 'sort_order' => 2, 'is_active' => true]);
Status::create(['name' => 'Resolved', 'code' => 'resolved', 'color' => '#10b981', 'sort_order' => 3, 'is_active' => true]);
Status::create(['name' => 'Closed', 'code' => 'closed', 'color' => '#6b7280', 'sort_order' => 4, 'is_active' => true]);

Priority::create(['name' => 'Low', 'code' => 'low', 'color' => '#6b7280', 'sort_order' => 1, 'is_active' => true]);
Priority::create(['name' => 'Medium', 'code' => 'medium', 'color' => '#f59e0b', 'sort_order' => 2, 'is_active' => true]);
Priority::create(['name' => 'High', 'code' => 'high', 'color' => '#ef4444', 'sort_order' => 3, 'is_active' => true]);
```

---

## Usage

- Admin panel: Manage tickets, categories, priorities, statuses, etc.
- Customer-facing: Contact form and portal access for ticket management.

---

## Troubleshooting

- Confirm Bagisto version is 2.3.8 and Laravel is 11.x.
- Run `composer dump-autoload` if you experience autoloading issues.
- Review [README.md](https://github.com/kevinbharris/support/blob/main/README.md) and [INSTALLATION.md](https://github.com/kevinbharris/support/blob/main/INSTALLATION.md) for more help.

---
