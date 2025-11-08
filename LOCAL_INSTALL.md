# Local Install (without packlyst) Guide for Bagisto Extension (`kevinbharris/support`)
_Install as a local package (not on Packagist) in Bagisto v2.3.8 / Laravel 11_

---

## Prerequisites

- **PHP:** 8.1+
- **Laravel:** 11.x
- **Bagisto:** 2.3.8
- **Composer**
- **Git** (for cloning, recommended)

---

## Installation Steps

### 1. Clone or Download the `kevinbharris/support` Repository

Clone the package into a suitable directory (such as `packages/kevinbharris/support`):

```bash
mkdir -p packages/kevinbharris
git clone https://github.com/kevinbharris/support.git packages/kevinbharris/support
```

Alternatively, download and extract the ZIP manually to `packages/kevinbharris/support`.

---

### 2. Configure Composer to Use the Local Package

Open your Bagisto project's `composer.json` and add this under `repositories`:

```json
"repositories": [
    {
        "type": "path",
        "url": "packages/kevinbharris/support"
    }
]
```

Add `"kevinbharris/support": "*"` to your `require` section:

```json
"require": {
    "kevinbharris/support": "dev-main"
}
```

---

### 3. Install & Autoload the Package

Run:

```bash
composer update kevinbharris/support
```

If you see any autoloading issues or the package isn't detected, try:

```bash
composer dump-autoload
```

---

### 4. Publish Configuration & Views

Publish the configuration file (optional):

```bash
php artisan vendor:publish --tag=support-config
```

Publish views if needed:

```bash
php artisan vendor:publish --tag=support-views
```

---

### 5. Environment Setup

Edit your `.env` file:

```env
SUPPORT_FROM_EMAIL=support@yourdomain.com
SUPPORT_FROM_NAME="Your Support Team"
SUPPORT_SLACK_ENABLED=false
SUPPORT_SLACK_WEBHOOK_URL=
SUPPORT_SLACK_CHANNEL=#support
SUPPORT_SLACK_USERNAME="Support Bot"
```

---

### 6. Run Database Migrations

```bash
php artisan migrate
```
Creates all support tables.

---

### 7. Seed Default Data

Use the admin panel or seed with tinker:

```php
use KevinBHarris\Support\Models\Status;
use KevinBHarris\Support\Models\Priority;
use KevinBHarris\Support\Models\Category;

Status::create(['name' => 'New', 'code' => 'new', 'color' => '#3b82f6', 'sort_order' => 1, 'is_active' => true]);
Status::create(['name' => 'Open', 'code' => 'open', 'color' => '#f59e0b', 'sort_order' => 2, 'is_active' => true]);
Status::create(['name' => 'On-Hold', 'code' => 'on_hold', 'color' => '#d97706', 'sort_order' => 3, 'is_active' => true]);
Status::create(['name' => 'In-Progress', 'code' => 'in_progress', 'color' => '#6366f1', 'sort_order' => 4, 'is_active' => true]);
Status::create(['name' => 'Resolved', 'code' => 'resolved', 'color' => '#10b981', 'sort_order' => 5, 'is_active' => true]);
Status::create(['name' => 'Closed', 'code' => 'closed', 'color' => '#6b7280', 'sort_order' => 6, 'is_active' => true]);
Priority::create(['name' => 'Low', 'code' => 'low', 'color' => '#6b7280', 'sort_order' => 1, 'is_active' => true]);
Priority::create(['name' => 'Medium', 'code' => 'medium', 'color' => '#f59e0b', 'sort_order' => 2, 'is_active' => true]);
Priority::create(['name' => 'High', 'code' => 'high', 'color' => '#ef4444', 'sort_order' => 3, 'is_active' => true]);
Category::create(['name' => 'Order Issues', 'code' => 'order-issues', 'color' => '#ef4444', 'sort_order' => 1, 'is_active' => true]);
Category::create(['name' => 'Billing & Invoicing', 'code' => 'billing-invoicing', 'color' => '#f59e0b', 'sort_order' => 2, 'is_active' => true]);
Category::create(['name' => 'Damaged Goods', 'code' => 'damaged-goods', 'color' => '#10b981', 'sort_order' => 3, 'is_active' => true]);
Category::create(['name' => 'Returns & Refunds', 'code' => 'returns-refunds', 'color' => '#6b7280', 'sort_order' => 4, 'is_active' => true]);
Category::create(['name' => 'Shipping Delays', 'code' => 'shipping-delays', 'color' => '#3b82f6', 'sort_order' => 5, 'is_active' => true]);
Category::create(['name' => 'Lost Packages', 'code' => 'lost-packages', 'color' => '#059669', 'sort_order' => 6, 'is_active' => true]);
Category::create(['name' => 'Incorrect Items', 'code' => 'incorrect-items', 'color' => '#6366f1', 'sort_order' => 7, 'is_active' => true]);
Category::create(['name' => 'Product Inquiry', 'code' => 'product-inquiry', 'color' => '#64748b', 'sort_order' => 8, 'is_active' => true]);
Category::create(['name' => 'Technical Support', 'code' => 'technical-support', 'color' => '#d97706', 'sort_order' => 9, 'is_active' => true]);
Category::create(['name' => 'Warranty Claims', 'code' => 'warranty-claims', 'color' => '#c026d3', 'sort_order' => 10, 'is_active' => true]);
Category::create(['name' => 'Replacement Requests', 'code' => 'replacement-requests', 'color' => '#f472b6', 'sort_order' => 11, 'is_active' => true]);
Category::create(['name' => 'Bulk Purchase Quote', 'code' => 'bulk-quote', 'color' => '#22d3ee', 'sort_order' => 12, 'is_active' => true]);
Category::create(['name' => 'Account Management', 'code' => 'account-management', 'color' => '#eab308', 'sort_order' => 13, 'is_active' => true]);
Category::create(['name' => 'Office Supplies Request', 'code' => 'supplies-request', 'color' => '#84cc16', 'sort_order' => 14, 'is_active' => true]);
Category::create(['name' => 'Furniture Setup', 'code' => 'furniture-setup', 'color' => '#a3e635', 'sort_order' => 15, 'is_active' => true]);
Category::create(['name' => 'Printer/Copier Support', 'code' => 'printer-support', 'color' => '#14b8a6', 'sort_order' => 16, 'is_active' => true]);
Category::create(['name' => 'IT Supplies', 'code' => 'it-supplies', 'color' => '#e11d48', 'sort_order' => 17, 'is_active' => true]);
Category::create(['name' => 'Janitorial Supplies', 'code' => 'janitorial-supplies', 'color' => '#c026d3', 'sort_order' => 18, 'is_active' => true]);
Category::create(['name' => 'Breakroom Supplies', 'code' => 'breakroom-supplies', 'color' => '#facc15', 'sort_order' => 19, 'is_active' => true]);
Category::create(['name' => 'Custom Orders', 'code' => 'custom-orders', 'color' => '#db2777', 'sort_order' => 20, 'is_active' => true]);
Category::create(['name' => 'General Inquiry', 'code' => 'general-inquiry', 'color' => '#6b7280', 'sort_order' => 21, 'is_active' => true]);
Category::create(['name' => 'Service Scheduling', 'code' => 'service-scheduling', 'color' => '#4ade80', 'sort_order' => 22, 'is_active' => true]);
Category::create(['name' => 'Contract & Terms', 'code' => 'contract-terms', 'color' => '#a3e635', 'sort_order' => 23, 'is_active' => true]);
Category::create(['name' => 'Feedback & Suggestions', 'code' => 'feedback', 'color' => '#60a5fa', 'sort_order' => 24, 'is_active' => true]);
Category::create(['name' => 'Other', 'code' => 'other', 'color' => '#f59e0b', 'sort_order' => 25, 'is_active' => true]);
```





---

## Usage

- Admin panel: Manage tickets, categories, priorities, statuses, etc.
- Customers: Use contact form & portal for ticket management.

---

## Troubleshooting

- Confirm the package path in `composer.json` matches where you placed support.
- If the package is not detected, run `composer dump-autoload`.
- For advanced issues: check the documentation, codebase, or open an issue on GitHub.

---

**See also:**  
- [INSTALLATION.md](https://github.com/kevinbharris/support/blob/main/INSTALLATION.md)  
- [README.md](https://github.com/kevinbharris/support/blob/main/README.md)
