# For Maintainers: ACL Integration Guide

This document explains the ACL integration for future maintenance and extension.

## What Was Done

We integrated a complete Access Control List (ACL) system that works seamlessly with Bagisto's native permission management. The implementation follows Bagisto conventions and requires zero manual setup from users.

## Architecture Overview

### 1. Permission Definition (`src/Config/acl.php`)

This is the source of truth for all permissions. The structure matches Bagisto's ACL format:

```php
[
    'key' => 'support.tickets.view',      // Unique permission identifier
    'name' => 'support::acl.tickets.view', // Translation key
    'route' => 'admin.support.tickets.index', // Associated route (optional)
    'sort' => 1,                           // Display order
]
```

**Important**: When you add a new permission here, it automatically:
- Appears in Bagisto's Settings > Roles UI
- Gets registered as a Laravel Gate
- Can be checked via `$user->hasPermission()`

### 2. Policy Classes (`src/Policies/`)

Each major model has a policy class that implements authorization logic. The pattern is:

```php
public function actionName($user, ?$model = null): bool
{
    return $user->hasPermission('support.resource.action');
}
```

**Why this works**: Bagisto's User model has a `hasPermission()` method that checks the user's assigned role permissions against the database.

### 3. Registration (`src/Providers/AuthServiceProvider.php`)

Two things happen here:
1. Policies are mapped to models (standard Laravel)
2. Gates are dynamically created for each permission

This allows both approaches:
- Policy: `$this->authorize('update', $ticket)`
- Gate: `Gate::allows('support.tickets.update')`

### 4. Route Protection (`src/Routes/admin.php`)

Routes use the custom `support_permission` middleware:

```php
Route::get('tickets', [TicketController::class, 'index'])
    ->middleware('support_permission:support.tickets.view');
```

The middleware checks the gate, which calls `hasPermission()`, which checks the user's role in the database.

### 5. Menu Integration (`src/Config/menu.php`)

Menu items include a `permission` key:

```php
[
    'key' => 'support.tickets',
    'name' => 'Tickets',
    'route' => 'admin.support.tickets.index',
    'permission' => 'support.tickets.view', // Bagisto checks this
]
```

Bagisto's menu system automatically hides items if the user lacks the permission.

## How to Extend

### Adding a New Permission

1. **Define in ACL config** (`src/Config/acl.php`):
```php
[
    'key' => 'support.tickets.export',
    'name' => 'support::acl.tickets.export',
    'route' => null,
    'sort' => 10,
],
```

2. **Add translation** (`src/Resources/lang/en/acl.php`):
```php
'tickets' => [
    // ... existing
    'export' => 'Export Tickets',
],
```

3. **Add policy method** (if using policy authorization):
```php
// In TicketPolicy
public function export($user): bool
{
    return $user->hasPermission('support.tickets.export');
}
```

4. **Protect route**:
```php
Route::get('tickets/export', [TicketController::class, 'export'])
    ->middleware('support_permission:support.tickets.export');
```

5. **Use in views**:
```blade
@if(auth()->user()->hasPermission('support.tickets.export'))
    <a href="{{ route('admin.support.tickets.export') }}">Export</a>
@endif
```

That's it! The permission now appears in Settings > Roles automatically.

### Adding a New Resource (e.g., "Tags")

1. **Create policy** (`src/Policies/TagPolicy.php`):
```php
<?php

namespace KevinBHarris\Support\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use KevinBHarris\Support\Models\Tag;

class TagPolicy
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        return $user->hasPermission('support.tags.view');
    }

    public function view($user, Tag $tag): bool
    {
        return $user->hasPermission('support.tags.view');
    }

    public function create($user): bool
    {
        return $user->hasPermission('support.tags.create');
    }

    public function update($user, Tag $tag): bool
    {
        return $user->hasPermission('support.tags.update');
    }

    public function delete($user, Tag $tag): bool
    {
        return $user->hasPermission('support.tags.delete');
    }
}
```

2. **Register in AuthServiceProvider**:
```php
protected $policies = [
    // ... existing
    Tag::class => TagPolicy::class,
];
```

3. **Add to ACL config**:
```php
// Tag Permissions
[
    'key' => 'support.tags',
    'name' => 'support::acl.tags.title',
    'route' => 'admin.support.tags.index',
    'sort' => 7,
],
[
    'key' => 'support.tags.view',
    'name' => 'support::acl.tags.view',
    'route' => 'admin.support.tags.index',
    'sort' => 1,
],
// ... create, update, delete
```

4. **Add translations**:
```php
'tags' => [
    'title' => 'Tags',
    'view' => 'View Tags',
    'create' => 'Create Tags',
    'update' => 'Update Tags',
    'delete' => 'Delete Tags',
],
```

5. **Protect routes**:
```php
Route::middleware('support_permission:support.tags.view')->group(function () {
    Route::get('tags', [TagController::class, 'index'])->name('admin.support.tags.index');
});
// ... etc
```

6. **Add to menu** (`src/Config/menu.php`):
```php
[
    'key'   => 'support.tags',
    'name' => 'Tags',
    'route' => 'admin.support.tags.index',
    'icon'  => 'icon-tags',
    'sort'  => 7,
    'permission' => 'support.tags.view',
],
```

### Adding Complex Authorization Logic

If you need more than just permission checks, you can enhance policy methods:

```php
public function update($user, Ticket $ticket): bool
{
    // Check permission first
    if (!$user->hasPermission('support.tickets.update')) {
        return false;
    }
    
    // Additional logic: users can only update tickets they created
    // or tickets assigned to them
    return $ticket->created_by === $user->id 
        || $ticket->assigned_to === $user->id;
}
```

However, be careful with this approach as Bagisto's role system won't reflect these nuances.

## Integration with Bagisto

### How Permissions Appear in Admin UI

When Bagisto loads the Roles page:
1. It reads all `acl` config files (including ours via `mergeConfigFrom`)
2. Groups permissions by their key prefix (e.g., `support.*`)
3. Displays them in a tree structure
4. Stores checked permissions in the `roles` table

### How Permission Checks Work

```
User Request
    ↓
Middleware: support_permission:support.tickets.view
    ↓
Gate::allows('support.tickets.view')
    ↓
AuthServiceProvider registered gate callback
    ↓
$user->hasPermission('support.tickets.view')
    ↓
Bagisto checks user's role in database
    ↓
Returns true/false
```

## Files Modified in Base Package

| File | What Changed |
|------|--------------|
| `src/Providers/SupportServiceProvider.php` | Added ACL config merging, middleware registration, AuthServiceProvider registration |
| `src/Routes/admin.php` | Added middleware to all routes |
| `src/Config/menu.php` | Added permission keys to menu items |
| `README.md` | Added ACL section |

## New Files Added

| File | Purpose |
|------|---------|
| `src/Config/acl.php` | Permission definitions |
| `src/Policies/*.php` | 8 policy classes |
| `src/Providers/AuthServiceProvider.php` | Policy & gate registration |
| `src/Http/Middleware/SupportPermission.php` | Permission middleware |
| `src/Resources/lang/en/acl.php` | Permission translations |
| `src/Database/Seeders/SupportPermissionsSeeder.php` | Optional seeder (reference only) |
| `examples/blade-acl-examples.blade.php` | Usage examples |
| `ACL.md` | User documentation |
| `ACL_QUICKSTART.md` | Quick start guide |
| `ACL_IMPLEMENTATION.md` | Technical summary |
| `MAINTAINERS_ACL.md` | This file |

## Common Maintenance Tasks

### Adding a permission to existing resource

1. Add to `acl.php`
2. Add translation
3. Add policy method (optional)
4. Protect route with middleware
5. Use in views

### Renaming a permission

**Don't!** This breaks existing role configurations. Instead:
1. Add the new permission
2. Deprecate the old one (keep in config but mark deprecated in docs)
3. Update code to check both
4. Remove old one in next major version

### Changing permission hierarchy

Bagisto's UI groups by key prefix. To reorganize:
1. Update `key` values in `acl.php`
2. Update all references (middleware, policies, views)
3. Document migration path for users

### Testing Permissions

```php
// In tests
use Tests\TestCase;

class TicketPermissionTest extends TestCase
{
    public function test_user_without_permission_cannot_view_tickets()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Limited', 'permission_type' => 'custom', 'permissions' => []]);
        $user->role_id = $role->id;
        $user->save();
        
        $this->actingAs($user)
             ->get(route('admin.support.tickets.index'))
             ->assertStatus(403);
    }
    
    public function test_user_with_permission_can_view_tickets()
    {
        $user = User::factory()->create();
        $role = Role::create([
            'name' => 'Support', 
            'permission_type' => 'custom', 
            'permissions' => ['support.tickets.view']
        ]);
        $user->role_id = $role->id;
        $user->save();
        
        $this->actingAs($user)
             ->get(route('admin.support.tickets.index'))
             ->assertStatus(200);
    }
}
```

## Troubleshooting

### Permissions not appearing in admin

- Check `mergeConfigFrom` in SupportServiceProvider
- Clear config cache: `php artisan config:clear`
- Verify ACL config array structure matches Bagisto format

### Middleware not working

- Verify middleware is registered in SupportServiceProvider
- Check middleware alias is correct in routes
- Ensure AuthServiceProvider is registered

### Policy not being called

- Check policy is registered in AuthServiceProvider's `$policies` array
- Verify model class name matches exactly
- Clear cache

## Best Practices

1. **Always use `hasPermission()`**: Don't check database directly
2. **Use middleware for routes**: Don't rely only on policy checks
3. **Check permissions in views**: Hide UI elements user can't use
4. **Group related permissions**: Use consistent naming (resource.action)
5. **Document new permissions**: Update ACL.md when adding permissions
6. **Don't bypass ACL**: Even for "admin" actions
7. **Test permission changes**: Verify in actual Bagisto install
8. **Keep translations updated**: Add entries for new permissions

## Future Considerations

Potential enhancements:

1. **Department-based permissions**: Restrict to specific support departments
2. **Ownership checks**: Can only update own tickets
3. **Conditional permissions**: Based on ticket status, priority, etc.
4. **Time-based access**: Support hours restrictions
5. **IP-based restrictions**: Office-only access for certain actions
6. **Two-factor for sensitive actions**: Delete, bulk actions
7. **Audit logging**: Track who did what

For these, you'd extend the policy methods with additional logic beyond simple `hasPermission()` checks.

## Questions?

If you need to understand specific parts of the implementation:
- Check `ACL_IMPLEMENTATION.md` for technical details
- Review `examples/blade-acl-examples.blade.php` for usage patterns
- Read Laravel's authorization docs for policy/gate concepts
- Check Bagisto's core ACL implementation for reference
