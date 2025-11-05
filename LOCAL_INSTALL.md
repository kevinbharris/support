# Local Install Guide for Bagisto Extension (`kevinbharris/support`)
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
    "kevinbharris/support": "*"
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
Status::create(['name' => 'Resolved', 'code' => 'resolved', 'color' => '#10b981', 'sort_order' => 3, 'is_active' => true]);
Status::create(['name' => 'Closed', 'code' => 'closed', 'color' => '#6b7280', 'sort_order' => 4, 'is_active' => true]);
Priority::create(['name' => 'Low', 'code' => 'low', 'color' => '#6b7280', 'sort_order' => 1, 'is_active' => true]);
Priority::create(['name' => 'Medium', 'code' => 'medium', 'color' => '#f59e0b', 'sort_order' => 2, 'is_active' => true]);
Priority::create(['name' => 'High', 'code' => 'high', 'color' => '#ef4444', 'sort_order' => 3, 'is_active' => true]);
```

---

## Usage

- Admin panel: Manage tickets, categories, priorities, statuses, etc.
- Customers: Use CMS-based contact page & portal for ticket management.

---

## Creating a Contact/Help Desk Page with Bagisto CMS

Instead of using a hardcoded contact route, create a custom CMS page in Bagisto for your support contact form. This provides more flexibility and allows you to customize the page content through the admin panel.

### Steps to Create CMS Contact Page:

1. **Navigate to Bagisto Admin**: Go to **Settings** > **Content** > **Pages**
2. **Create New Page**: Click **Add Page**
3. **Configure Page Settings**:
   - **Page Title**: Contact Support / Help Desk
   - **URL Key**: `contact` or `help`
   - **Status**: Enable
   - **Channels**: Select appropriate channels
4. **Add HTML Content**: In the content editor, switch to **HTML Source** mode and paste the following sample form:

```html
<h2>Contact Our Help Desk</h2>
<p>If you need help, please use the form below to get in touch with our support team.</p>
<form action="/support/contact" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
    <label for="customer_name">Your Name:</label><br>
    <input type="text" name="customer_name" id="customer_name" required><br><br>
    
    <label for="customer_email">Your Email:</label><br>
    <input type="email" name="customer_email" id="customer_email" required><br><br>
    
    <label for="category_id">Category:</label><br>
    <select name="category_id" id="category_id" required>
        <option value="">-- Select Category --</option>
        <option value="1">General</option>
        <option value="2">Technical</option>
        <option value="3">Billing</option>
    </select><br><br>
    
    <label for="subject">Subject:</label><br>
    <input type="text" name="subject" id="subject" required><br><br>
    
    <label for="description">Message:</label><br>
    <textarea name="description" id="description" rows="5" required></textarea><br><br>
    
    <button type="submit">Send</button>
</form>
```

5. **Update Category Values**: Adjust the category option values to match your actual category IDs from the admin panel
6. **Save and Publish**: Save the page and verify it's accessible at `/content/contact` (or your chosen URL key)

**Note**: The form submits to `/support/contact` which creates a new support ticket. Make sure you have created at least one category, status, and priority in the admin panel before testing the form.

---

## Troubleshooting

- Confirm the package path in `composer.json` matches where you placed support.
- If the package is not detected, run `composer dump-autoload`.
- For advanced issues: check the documentation, codebase, or open an issue on GitHub.

---

**See also:**  
- [INSTALLATION.md](https://github.com/kevinbharris/support/blob/main/INSTALLATION.md)  
- [README.md](https://github.com/kevinbharris/support/blob/main/README.md)
