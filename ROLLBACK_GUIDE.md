# Server Rollback Guide - ACL Integration Removal

This guide explains how to rollback from the ACL-enabled version of the Support package to the non-ACL version on a live server installation.

## Overview

The Support package has been rolled back to remove all ACL (Access Control List) integration. This means:
- No more role-based permission checking for support features
- All authenticated admin users can access all support features
- Database tables remain unchanged (tickets, statuses, priorities, etc. are preserved)
- Only the permission layer has been removed

## Rollback Steps

### 1. Update the Package

Update to the latest version of the support package:

```bash
composer update kevinbharris/support
```

### 2. Clear Application Caches

Clear all Laravel caches to ensure the old ACL configuration is removed:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 3. Verify the Update

Check that the package has been updated successfully:

```bash
composer show kevinbharris/support
```

The version should reflect the rollback (no ACL support).

### 4. Test Admin Access

1. Log in to the Bagisto admin panel
2. Navigate to the Support menu
3. Verify that all support features are accessible without permission errors

## Database Cleanup (Optional)

### Remove Old ACL Permissions

The old ACL permissions registered in Bagisto's roles table will remain in the database but will not be used. If you want to clean them up:

1. Go to **Admin > Settings > Roles**
2. Edit roles that have Support permissions
3. Remove permissions starting with `support.*` (e.g., `support.tickets.view`, `support.tickets.create`)
4. Save the role

Alternatively, if you created roles specifically for Support module permissions, you can delete those roles entirely.

**Note**: This is optional. Leaving the permissions in the database will not cause any issues.

### SQL Cleanup (Advanced)

If you want to programmatically remove all Support permissions from roles, you can run this SQL query:

```sql
-- This removes all support.* permissions from the admin_roles table
-- WARNING: Backup your database before running this!

UPDATE admin_roles 
SET permissions = JSON_REMOVE(
    permissions,
    JSON_UNQUOTE(JSON_SEARCH(permissions, 'all', 'support.%'))
) 
WHERE JSON_SEARCH(permissions, 'all', 'support.%') IS NOT NULL;
```

**Important**: Always backup your database before running SQL commands directly.

## What Changed?

### Removed Files
- `ACL.md` - ACL documentation
- `ACL_QUICKSTART.md` - Quick start guide for ACL
- `ACL_IMPLEMENTATION.md` - Implementation details
- `MAINTAINERS_ACL.md` - Maintainer guide for ACL
- `examples/blade-acl-examples.blade.php` - Example blade code for ACL
- `src/Config/acl.php` - ACL configuration
- `src/Resources/lang/en/acl.php` - ACL translations
- `src/Policies/*` - All policy classes
- `src/Providers/AuthServiceProvider.php` - Auth service provider
- `src/Http/Middleware/SupportPermission.php` - Permission middleware
- `src/Database/Seeders/SupportPermissionsSeeder.php` - Permissions seeder

### Modified Files
- `src/Providers/SupportServiceProvider.php` - Removed ACL registration
- `src/Routes/admin.php` - Removed permission middleware from routes
- `src/Config/menu.php` - Removed permission keys from menu items
- `README.md` - Removed ACL documentation sections

### Unchanged Components
- All database migrations remain the same
- All models (Ticket, Status, Priority, etc.) remain unchanged
- All controllers remain unchanged
- All views remain unchanged
- Customer portal functionality remains unchanged
- Email notifications remain unchanged
- Slack integration remains unchanged

## What This Means for Your Installation

### Before Rollback (With ACL)
- Fine-grained permission control per resource (tickets, statuses, etc.)
- Different roles could have different access levels
- Routes were protected by permission middleware
- Menu items were hidden based on permissions

### After Rollback (Without ACL)
- All authenticated admin users can access all support features
- No permission checks on routes
- All menu items visible to all admin users
- Simpler administration (no need to configure support permissions)

## Security Considerations

**Important**: After this rollback, all authenticated admin users will have full access to the Support module features. If you need to restrict access:

1. Use Bagisto's built-in admin authentication (users must still log in)
2. Consider using custom middleware if you need specific access restrictions
3. Implement your own permission layer if needed

## Troubleshooting

### Issue: Routes return 403 Forbidden
**Solution**: Make sure you've cleared all caches (step 2 above). If the issue persists:
```bash
php artisan optimize:clear
composer dump-autoload
```

### Issue: Menu items don't appear
**Solution**: Clear the view and config cache:
```bash
php artisan view:clear
php artisan config:clear
```

### Issue: Old permissions still show in roles
**Solution**: This is expected behavior. The permissions will not be used even if they appear in the database. You can remove them manually or leave them (see "Database Cleanup" section above).

### Issue: Package update fails
**Solution**: 
```bash
composer clear-cache
composer update kevinbharris/support --with-all-dependencies
```

## Support

If you encounter any issues during the rollback process:

1. Check this guide thoroughly
2. Review the [CHANGELOG.md](CHANGELOG.md) for detailed changes
3. Open an issue on GitHub: https://github.com/kevinbharris/support/issues
4. Contact: kevin.b.harris.2015@gmail.com

## Reverting the Rollback

If you need to go back to the ACL-enabled version:

```bash
# Replace X.X.X with the last ACL-enabled version number
composer require kevinbharris/support:X.X.X
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

Check the package releases on GitHub to find the last version with ACL support.
