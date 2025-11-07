# ACL Quick Start Guide

This guide shows you how to set up permissions for the Support module in under 5 minutes.

## Prerequisites

- Support module installed via Composer
- Bagisto v2.3.8 or higher
- Admin access to Bagisto panel

## Step-by-Step Setup

### Step 1: Verify Installation

The ACL system is automatically configured when you install the Support module. No additional setup is required!

To verify:
```bash
# Clear cache
php artisan config:clear
php artisan cache:clear
```

### Step 2: Configure Permissions in Admin Panel

#### For Full Support Access (Admins)

1. Login to Bagisto Admin
2. Navigate to **Settings > Roles**
3. Click **Create Role** or edit an existing admin role
4. In the **Permissions** section, expand **Support** or **Help Desk**
5. Check **all** Support permissions
6. Click **Save**

#### For Support Agents (Limited Access)

1. Navigate to **Settings > Roles**
2. Click **Create Role**
3. Name: "Support Agent"
4. In permissions, check:
   - ✅ Support > Tickets > View
   - ✅ Support > Tickets > Create  
   - ✅ Support > Tickets > Update
   - ✅ Support > Tickets > Add Notes
   - ✅ Support > Statuses > View
   - ✅ Support > Priorities > View
   - ✅ Support > Categories > View
   - ✅ Support > Canned Responses > View
5. Click **Save**

#### For Support Viewers (Read-Only)

1. Navigate to **Settings > Roles**
2. Click **Create Role**
3. Name: "Support Viewer"
4. In permissions, check only **View** permissions:
   - ✅ Support > Tickets > View
   - ✅ Support > Statuses > View
   - ✅ Support > Priorities > View
   - ✅ Support > Categories > View
   - ✅ Support > Notes > View
5. Click **Save**

### Step 3: Assign Roles to Users

1. Navigate to **Settings > Users**
2. Click on a user to edit
3. In the **Role** dropdown, select the appropriate role
4. Click **Save**

### Step 4: Test Permissions

1. Logout from admin
2. Login as a user with the new role
3. Check that:
   - Menu items appear/disappear based on permissions
   - Attempting to access unauthorized pages shows 403 error
   - Action buttons (Create, Edit, Delete) show only when permitted

## Common Permission Sets

### Support Manager
```
✅ All Support permissions
```

### Support Agent
```
✅ Tickets: View, Create, Update, Add Notes
✅ All config sections: View only
❌ Tickets: Delete, Assign
❌ All config sections: Create, Update, Delete
```

### Support Viewer
```
✅ All View permissions
❌ All Create, Update, Delete permissions
```

### Customer Service Rep
```
✅ Tickets: View, Create, Add Notes
✅ Canned Responses: View
❌ Everything else
```

## Troubleshooting

### Permissions not showing in admin panel

```bash
# Clear cache and rebuild config
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

### User can't access support module

1. Verify user has a role assigned
2. Check role has at least "View" permissions for Support
3. Check user is logged in to admin panel
4. Clear browser cache

### 403 Forbidden error

This is normal! It means permission checking is working. The user needs the appropriate permission for that action.

To fix:
1. Go to Settings > Roles
2. Edit the user's role
3. Add the required permission
4. User may need to logout/login

### Menu items not appearing

This is expected behavior. Menu items only show if the user has view permission.

To fix:
1. Edit the user's role
2. Add "View" permission for that section
3. Refresh the page

## Advanced: Programmatic Setup (Optional)

If you need to create roles programmatically (CI/CD, automated deployments):

```bash
php artisan db:seed --class="KevinBHarris\Support\Database\Seeders\SupportPermissionsSeeder"
```

This creates three default roles:
- Support Admin (full access)
- Support Agent (limited access)
- Support Viewer (read-only)

**Note**: This is completely optional. Most users should use the admin panel.

## Next Steps

- Read [ACL.md](ACL.md) for detailed documentation
- Check [examples/blade-acl-examples.blade.php](examples/blade-acl-examples.blade.php) for view integration
- Review [ACL_IMPLEMENTATION.md](ACL_IMPLEMENTATION.md) for technical details

## Quick Reference

| Permission | Allows User To |
|------------|----------------|
| `support.tickets.view` | See tickets list and details |
| `support.tickets.create` | Create new tickets |
| `support.tickets.update` | Edit existing tickets |
| `support.tickets.delete` | Delete tickets |
| `support.tickets.assign` | Assign tickets to team members |
| `support.tickets.notes` | Add notes to tickets |
| `support.tickets.watchers` | Add/remove ticket watchers |
| `support.*.view` | View resource lists |
| `support.*.create` | Create new resources |
| `support.*.update` | Edit existing resources |
| `support.*.delete` | Delete resources |

Replace `*` with: statuses, priorities, categories, canned-responses, rules, notes, attachments

## Support

Having issues? Check:
1. Bagisto version (must be 2.3.8+)
2. Cache cleared
3. User has role assigned
4. Role has appropriate permissions
