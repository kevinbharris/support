# ACL Integration - Implementation Summary

This document provides a technical summary of the ACL (Access Control List) integration for the Support module.

## Overview

The Support module now fully integrates with Bagisto's native ACL system, providing fine-grained permission control for all support resources and actions. All permissions are automatically available in the Bagisto admin panel without requiring any manual setup or seeders.

## What Was Implemented

### 1. Configuration Files

#### `src/Config/acl.php`
Defines all support permissions in Bagisto's ACL format. Includes:
- 8 resource types (Tickets, Statuses, Priorities, Categories, Canned Responses, Rules, Notes, Attachments)
- 33 total permissions
- Hierarchical structure with parent and child permissions
- Translation keys for permission names
- Route associations for menu integration

### 2. Policy Classes (`src/Policies/`)

Created 8 policy classes that implement Laravel's authorization system:

- **TicketPolicy** - 7 methods (viewAny, view, create, update, delete, assign, addNote, manageWatchers)
- **StatusPolicy** - 5 methods (viewAny, view, create, update, delete)
- **PriorityPolicy** - 5 methods (viewAny, view, create, update, delete)
- **CategoryPolicy** - 5 methods (viewAny, view, create, update, delete)
- **CannedResponsePolicy** - 5 methods (viewAny, view, create, update, delete)
- **RulePolicy** - 5 methods (viewAny, view, create, update, delete)
- **NotePolicy** - 4 methods (viewAny, view, create, delete)
- **AttachmentPolicy** - 4 methods (viewAny, view, create, delete)

Each policy integrates with Bagisto's `hasPermission()` method for checking user permissions.

### 3. AuthServiceProvider (`src/Providers/AuthServiceProvider.php`)

- Registers all 8 policies with their corresponding models
- Dynamically creates Laravel Gates for each permission
- Allows both policy-based (`$this->authorize()`) and gate-based (`Gate::allows()`) authorization

### 4. Middleware (`src/Http/Middleware/SupportPermission.php`)

- Custom middleware for route-level permission checking
- Integrates with Laravel's Gate system
- Returns 403 Forbidden for unauthorized access
- Redirects unauthenticated users to login

### 5. Route Protection (`src/Routes/admin.php`)

Updated all admin routes with permission middleware:
- View routes → `support_permission:support.*.view`
- Create routes → `support_permission:support.*.create`
- Update routes → `support_permission:support.*.update`
- Delete routes → `support_permission:support.*.delete`
- Special actions → dedicated permissions (assign, notes, watchers)

### 6. Menu Configuration (`src/Config/menu.php`)

Added `permission` keys to all menu items:
- Menu items only show for users with view permissions
- Integrates with Bagisto's menu system
- Hierarchical menu structure maintained

### 7. Language Files (`src/Resources/lang/en/acl.php`)

Translation strings for all permissions in English:
- Organized by resource type
- Human-readable permission names
- Ready for multi-language support

### 8. Service Provider Updates (`src/Providers/SupportServiceProvider.php`)

- Registered AuthServiceProvider
- Merged ACL configuration
- Registered middleware alias
- Added translation loading
- Made ACL config publishable

### 9. Documentation

#### `ACL.md`
Comprehensive documentation covering:
- Permission structure and organization
- Configuration in Bagisto admin panel
- Policy usage examples
- Blade directive examples
- Route middleware usage
- Troubleshooting guide
- Migration guide
- Best practices

#### `examples/blade-acl-examples.blade.php`
10 practical examples of using ACL in Blade templates:
- Show/hide buttons based on permissions
- Conditional form rendering
- Navigation menu filtering
- Table action columns
- Bulk actions
- Using `@can`, `@cannot`, `@canany` directives
- Using `hasPermission()` helper
- Using Gate facade

#### `README.md` Updates
Added ACL section explaining:
- How to configure permissions
- Link to detailed ACL documentation
- Quick setup guide

### 10. Optional Seeder (`src/Database/Seeders/SupportPermissionsSeeder.php`)

Provided for reference only - creates 3 example roles:
- Support Admin (full permissions)
- Support Agent (limited permissions)
- Support Viewer (read-only)

**Note**: Not required for normal usage since Bagisto admin panel handles role configuration.

## Integration Points

### With Bagisto ACL System

1. **Permission Registration**: Permissions automatically appear in Settings > Roles
2. **Role Management**: Fully integrated with Bagisto's role editor
3. **Menu System**: Menu items respect permission settings
4. **User Model**: Uses Bagisto's `hasPermission()` method

### With Laravel Authorization

1. **Policies**: Standard Laravel policy classes
2. **Gates**: Automatic gate registration for all permissions
3. **Middleware**: Custom middleware using Gate::allows()
4. **Blade Directives**: Support for @can, @cannot, @canany

## How It Works

```
User Request → Middleware Check → Gate::allows(permission)
                                         ↓
                                 User→hasPermission()
                                         ↓
                                 Check Role Permissions
                                         ↓
                              Allow/Deny Access
```

## Usage Flow

### Admin Configuration
1. Admin goes to Settings > Roles
2. Creates/edits a role
3. Checks desired Support permissions
4. Saves role
5. Assigns role to users

### Permission Enforcement
1. User navigates to support route
2. Middleware checks permission via Gate
3. Gate calls user's hasPermission() method
4. Bagisto checks user's role permissions
5. Access granted or denied

### View Rendering
1. Blade template uses @can directive
2. Laravel checks policy method
3. Policy calls hasPermission()
4. UI element shown/hidden based on result

## File Structure

```
src/
├── Config/
│   └── acl.php                           # Permission definitions
├── Policies/
│   ├── TicketPolicy.php                  # Ticket authorization
│   ├── StatusPolicy.php                  # Status authorization
│   ├── PriorityPolicy.php                # Priority authorization
│   ├── CategoryPolicy.php                # Category authorization
│   ├── CannedResponsePolicy.php          # Canned response authorization
│   ├── RulePolicy.php                    # Rule authorization
│   ├── NotePolicy.php                    # Note authorization
│   └── AttachmentPolicy.php              # Attachment authorization
├── Providers/
│   └── AuthServiceProvider.php           # Policy & gate registration
├── Http/
│   └── Middleware/
│       └── SupportPermission.php         # Permission middleware
├── Resources/
│   └── lang/
│       └── en/
│           └── acl.php                   # Permission translations
└── Database/
    └── Seeders/
        └── SupportPermissionsSeeder.php  # Optional seeder

examples/
└── blade-acl-examples.blade.php          # Blade usage examples

ACL.md                                     # Main ACL documentation
```

## Testing Checklist

To verify ACL integration:

- [ ] Install package in Bagisto
- [ ] Navigate to Settings > Roles
- [ ] Verify Support permissions appear in list
- [ ] Create a new role with limited support permissions
- [ ] Assign role to a test user
- [ ] Login as test user
- [ ] Verify menu items show/hide based on permissions
- [ ] Verify routes are protected (403 on unauthorized access)
- [ ] Test @can directives in views
- [ ] Test policy authorization in controllers

## Extensibility

### Adding New Permissions

1. Add to `src/Config/acl.php`
2. Add translation to `src/Resources/lang/en/acl.php`
3. Create/update policy class
4. Register policy in AuthServiceProvider
5. Apply middleware to routes
6. Use in Blade templates

### Adding New Policy Methods

```php
// In policy class
public function customAction($user, $model): bool
{
    return $user->hasPermission('support.resource.custom-action');
}

// In ACL config
[
    'key' => 'support.resource.custom-action',
    'name' => 'support::acl.resource.custom-action',
    'route' => null,
    'sort' => 10,
]

// In routes
Route::post('resource/custom', [Controller::class, 'customAction'])
    ->middleware('support_permission:support.resource.custom-action');
```

## Performance Considerations

- Gates are registered once per request
- Permission checks are cached by Bagisto
- Minimal overhead on route middleware
- Policy methods use simple boolean checks
- No database queries added for permission checking (handled by Bagisto)

## Security Notes

- All admin routes protected by middleware
- Default deny approach (no permission = no access)
- Guest users redirected to login
- 403 errors for authenticated users without permission
- No permission bypass mechanisms

## Future Enhancements

Possible additions (not currently implemented):
- Per-ticket ownership checks (assign to self only)
- Department-based permissions
- Category-specific permissions
- Time-based access controls
- Audit logging for permission changes

## Support

For questions or issues with ACL integration:
1. Check [ACL.md](ACL.md) documentation
2. Review example files in `examples/`
3. Verify Bagisto version compatibility (v2.3.8+)
4. Check Laravel authorization docs
