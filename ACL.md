# Support Module - Access Control List (ACL) Integration

This document explains how the Support module integrates with Bagisto's ACL (Access Control List) system to provide fine-grained permission control for all support resources and actions.

## Overview

The Support module now includes comprehensive permission management that integrates seamlessly with Bagisto's admin role and permission system. All support resources (tickets, statuses, priorities, categories, canned responses, rules, notes, and attachments) are protected by permission checks.

## Permission Structure

Permissions are organized hierarchically by resource type:

### Ticket Permissions
- `support.tickets.view` - View tickets list and individual tickets
- `support.tickets.create` - Create new tickets
- `support.tickets.update` - Edit existing tickets
- `support.tickets.delete` - Delete tickets
- `support.tickets.assign` - Assign tickets to team members
- `support.tickets.notes` - Add notes to tickets
- `support.tickets.watchers` - Manage ticket watchers

### Status Permissions
- `support.statuses.view` - View statuses
- `support.statuses.create` - Create new statuses
- `support.statuses.update` - Edit existing statuses
- `support.statuses.delete` - Delete statuses

### Priority Permissions
- `support.priorities.view` - View priorities
- `support.priorities.create` - Create new priorities
- `support.priorities.update` - Edit existing priorities
- `support.priorities.delete` - Delete priorities

### Category Permissions
- `support.categories.view` - View categories
- `support.categories.create` - Create new categories
- `support.categories.update` - Edit existing categories
- `support.categories.delete` - Delete categories

### Canned Response Permissions
- `support.canned-responses.view` - View canned responses
- `support.canned-responses.create` - Create new canned responses
- `support.canned-responses.update` - Edit existing canned responses
- `support.canned-responses.delete` - Delete canned responses

### Rule Permissions
- `support.rules.view` - View automation rules
- `support.rules.create` - Create new rules
- `support.rules.update` - Edit existing rules
- `support.rules.delete` - Delete rules

### Note Permissions
- `support.notes.view` - View notes on tickets
- `support.notes.create` - Add notes to tickets
- `support.notes.delete` - Delete notes

### Attachment Permissions
- `support.attachments.view` - View attachments
- `support.attachments.create` - Upload attachments
- `support.attachments.delete` - Delete attachments

## Configuration

### Publishing Configuration

To customize the main support configuration, publish it to your application:

```bash
php artisan vendor:publish --tag=support-config
```

This will create `config/support.php` and `config/menu.php`.

**Note**: The ACL configuration (`src/Config/acl.php`) is automatically merged with Bagisto's ACL at runtime and does NOT need to be published. This prevents accidentally overwriting Bagisto's core ACL configuration.

### Permission Configuration File

The ACL configuration is located at `src/Config/acl.php` and is automatically loaded. It returns a flat array of permissions:

```php
return [
    [
        'key' => 'support.tickets',
        'name' => 'support::acl.tickets.title',
        'route' => 'admin.support.tickets.index',
        'sort' => 1,
    ],
    [
        'key' => 'support.tickets.view',
        'name' => 'support::acl.tickets.view',
        'route' => 'admin.support.tickets.index',
        'sort' => 1,
    ],
    // ... more permissions
];
```

## Usage in Bagisto Admin

### Configuring Permissions in Admin Panel

All support permissions are automatically available in Bagisto's admin panel once the package is installed. No seeding required!

1. Navigate to **Settings > Roles** in the Bagisto admin panel
2. Create a new role or edit an existing one
3. In the permissions section, expand the **Support** or **Help Desk** section
4. You'll find all Support permissions grouped by resource type:
   - Tickets (view, create, update, delete, assign, notes, watchers)
   - Statuses (view, create, update, delete)
   - Priorities (view, create, update, delete)
   - Categories (view, create, update, delete)
   - Canned Responses (view, create, update, delete)
   - Rules (view, create, update, delete)
   - Notes (view, create, delete)
   - Attachments (view, create, delete)
5. Check the permissions you want to grant to this role
6. Save the role
7. Assign the role to users under **Settings > Users**

### Creating Custom Roles

You can create specialized roles for different support team members directly in the admin panel:

**Example: Support Agent Role**
1. Go to Settings > Roles > Create
2. Name: "Support Agent"
3. Select these permissions:
   - Support > Tickets > View ✓
   - Support > Tickets > Create ✓
   - Support > Tickets > Update ✓
   - Support > Tickets > Notes ✓
   - Support > Statuses > View ✓
   - Support > Priorities > View ✓
   - Support > Categories > View ✓
4. Save the role

**Example: Support Manager Role**
1. Go to Settings > Roles > Create
2. Name: "Support Manager"
3. Select all Support permissions ✓
4. Save the role

**Example: Support Viewer Role**
1. Go to Settings > Roles > Create
2. Name: "Support Viewer"
3. Select only "View" permissions:
   - Support > Tickets > View ✓
   - Support > Statuses > View ✓
   - Support > Priorities > View ✓
   - Support > Categories > View ✓
   - Support > Canned Responses > View ✓
   - Support > Rules > View ✓
   - Support > Notes > View ✓
   - Support > Attachments > View ✓
4. Save the role

## Policy Classes

The module includes policy classes for all major models that integrate with Laravel's authorization system:

- `TicketPolicy` - Authorization for Ticket model
- `StatusPolicy` - Authorization for Status model
- `PriorityPolicy` - Authorization for Priority model
- `CategoryPolicy` - Authorization for Category model
- `CannedResponsePolicy` - Authorization for CannedResponse model
- `RulePolicy` - Authorization for Rule model
- `NotePolicy` - Authorization for Note model
- `AttachmentPolicy` - Authorization for Attachment model

### Using Policies in Controllers

Policies are automatically enforced through route middleware, but you can also use them explicitly in controllers:

```php
// Check if user can create tickets
$this->authorize('create', Ticket::class);

// Check if user can update a specific ticket
$this->authorize('update', $ticket);

// Check if user can delete a ticket
$this->authorize('delete', $ticket);
```

### Using Gates

You can also check permissions using Laravel Gates:

```php
use Illuminate\Support\Facades\Gate;

// Check a specific permission
if (Gate::allows('support.tickets.create')) {
    // User can create tickets
}

// Deny access if permission not granted
Gate::authorize('support.tickets.delete');
```

## Blade Directives

In Blade templates, you can conditionally show/hide UI elements based on permissions:

```blade
{{-- Show create button only if user has permission --}}
@can('create', App\Models\Ticket::class)
    <a href="{{ route('admin.support.tickets.create') }}" class="btn btn-primary">
        Create Ticket
    </a>
@endcan

{{-- Check specific permission --}}
@if(auth()->user()->hasPermission('support.tickets.delete'))
    <button class="btn btn-danger">Delete</button>
@endif

{{-- Using Gate facade --}}
@if(Gate::allows('support.tickets.assign'))
    <form action="{{ route('admin.support.tickets.assign', $ticket->id) }}">
        <!-- Assign form -->
    </form>
@endif
```

## Route Middleware

All admin routes are protected with the `support_permission` middleware:

```php
Route::get('tickets', [TicketController::class, 'index'])
    ->middleware('support_permission:support.tickets.view');

Route::post('tickets', [TicketController::class, 'store'])
    ->middleware('support_permission:support.tickets.create');
```

## Automatic Permission Registration

The Support module automatically registers all permissions with Bagisto's ACL system. You don't need to run any seeders or manual setup steps. Simply:

1. Install the package
2. Go to Bagisto Admin > Settings > Roles
3. Create or edit roles and assign Support permissions
4. Assign roles to users

All Support permissions will appear grouped in the permissions section when editing a role.

## Optional: Programmatic Role Creation

If you need to programmatically create roles with support permissions (e.g., during initial setup), you can use the provided seeder as a reference. However, **this is entirely optional** since Bagisto's admin panel provides full UI-based role and permission management.

See `src/Database/Seeders/SupportPermissionsSeeder.php` for an example of how to create roles programmatically if needed for automated deployments.

## Extending the Policy Template

If you need to create additional policies, use the `TicketPolicy` as a template:

```php
<?php

namespace KevinBHarris\Support\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use KevinBHarris\Support\Models\YourModel;

class YourModelPolicy
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        return $user->hasPermission('support.yourmodel.view');
    }

    public function view($user, YourModel $model): bool
    {
        return $user->hasPermission('support.yourmodel.view');
    }

    public function create($user): bool
    {
        return $user->hasPermission('support.yourmodel.create');
    }

    public function update($user, YourModel $model): bool
    {
        return $user->hasPermission('support.yourmodel.update');
    }

    public function delete($user, YourModel $model): bool
    {
        return $user->hasPermission('support.yourmodel.delete');
    }
}
```

Then register it in `AuthServiceProvider`:

```php
protected $policies = [
    // ... existing policies
    YourModel::class => YourModelPolicy::class,
];
```

## Troubleshooting

### Permission Not Working

1. **Clear cache**: Run `php artisan config:clear` and `php artisan cache:clear`
2. **Check role assignment**: Ensure the user has a role with the required permissions
3. **Verify permission key**: Ensure the permission key in `acl.php` matches what you're checking

### 403 Unauthorized Error

If you see a 403 error:
1. Check that the user is logged in
2. Verify the user's role has the required permission
3. Check the middleware is correctly applied to the route
4. Ensure the permission key is correct

### Menu Items Not Showing

If menu items don't appear:
1. Verify the `permission` key is set in `menu.php`
2. Check the user has the view permission for that resource
3. Clear the configuration cache

## Best Practices

1. **Least Privilege**: Grant users only the permissions they need
2. **Role-Based**: Create roles for common permission sets rather than assigning individual permissions
3. **Regular Audits**: Periodically review role permissions to ensure they're still appropriate
4. **Documentation**: Document custom roles and their intended use cases
5. **Testing**: Test permission enforcement in both UI and API contexts

## Migration from Previous Versions

If you're upgrading from a version without ACL support:

1. Clear cache: `php artisan config:clear` and `php artisan cache:clear`
2. The ACL configuration is automatically merged at runtime - no publishing needed
3. Go to **Bagisto Admin > Settings > Roles**
4. Edit existing roles to include Support permissions as needed
5. Assign appropriate roles to existing users
6. Test that all users can access the features they need

**Note**: All permissions are automatically available in the admin panel. The ACL config is merged with Bagisto's configuration, not published separately.

## Additional Resources

- [Bagisto ACL Documentation](https://bagisto.com/en/docs/)
- [Laravel Authorization](https://laravel.com/docs/authorization)
- [Laravel Policies](https://laravel.com/docs/authorization#creating-policies)
- [Laravel Gates](https://laravel.com/docs/authorization#gates)
