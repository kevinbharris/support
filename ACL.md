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

To customize the ACL configuration, publish it to your application:

```bash
php artisan vendor:publish --tag=support-config
```

This will create `config/acl.php` with all permission definitions.

### Permission Configuration File

The ACL configuration is located at `src/Config/acl.php` and follows Bagisto's ACL structure:

```php
'permissions' => [
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
]
```

## Usage in Bagisto Admin

### Assigning Permissions to Roles

1. Navigate to **Settings > Roles** in the Bagisto admin panel
2. Create a new role or edit an existing one
3. In the permissions section, you'll find all Support permissions grouped by resource type
4. Check the permissions you want to grant to this role
5. Save the role

### Creating Custom Roles

You can create specialized roles for different support team members:

**Example: Support Agent Role**
- `support.tickets.view` ✓
- `support.tickets.update` ✓
- `support.tickets.notes` ✓
- `support.tickets.assign` ✗
- `support.tickets.delete` ✗

**Example: Support Manager Role**
- All ticket permissions ✓
- All status/priority/category permissions ✓
- `support.rules` permissions ✓

**Example: Support Viewer Role**
- `support.tickets.view` ✓
- `support.notes.view` ✓
- All other permissions ✗

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

## Seeding Permissions

To make it easier for developers to seed permissions into the ACL system, here's an example seeder:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\User\Models\Role;

class SupportPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Get or create a Support Admin role
        $role = Role::firstOrCreate(
            ['name' => 'Support Admin'],
            [
                'description' => 'Full access to support module',
                'permission_type' => 'custom',
            ]
        );

        // Define all support permissions
        $permissions = config('acl.permissions');
        
        // Extract just the permission keys
        $permissionKeys = collect($permissions)->pluck('key')->toArray();
        
        // Assign all support permissions to the role
        $role->permissions = array_merge($role->permissions ?? [], $permissionKeys);
        $role->save();
    }
}
```

Run the seeder:

```bash
php artisan db:seed --class=SupportPermissionsSeeder
```

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

1. Publish the new configuration: `php artisan vendor:publish --tag=support-config`
2. Create or update roles in Bagisto admin with support permissions
3. Assign appropriate roles to existing users
4. Test that all users can access the features they need

## Additional Resources

- [Bagisto ACL Documentation](https://bagisto.com/en/docs/)
- [Laravel Authorization](https://laravel.com/docs/authorization)
- [Laravel Policies](https://laravel.com/docs/authorization#creating-policies)
- [Laravel Gates](https://laravel.com/docs/authorization#gates)
