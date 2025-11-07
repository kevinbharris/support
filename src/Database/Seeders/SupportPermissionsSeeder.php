<?php

namespace KevinBHarris\Support\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\User\Models\Role;

/**
 * Support Permissions Seeder (OPTIONAL)
 * 
 * This seeder is provided as a REFERENCE ONLY for programmatic role creation.
 * 
 * Bagisto's admin panel (Settings > Roles) provides full UI-based permission
 * management, so this seeder is NOT required for normal usage.
 * 
 * Use this seeder only if you need to:
 * - Automate role creation in CI/CD pipelines
 * - Set up demo/test environments programmatically
 * - Provide default roles for custom installations
 * 
 * For most users, simply configure roles in the Bagisto admin panel.
 * 
 * Usage (optional):
 * php artisan db:seed --class="KevinBHarris\Support\Database\Seeders\SupportPermissionsSeeder"
 */
class SupportPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createSupportAdminRole();
        $this->createSupportAgentRole();
        $this->createSupportViewerRole();
    }

    /**
     * Create Support Admin role with full permissions.
     *
     * @return void
     */
    protected function createSupportAdminRole(): void
    {
        $role = Role::firstOrCreate(
            ['name' => 'Support Admin'],
            [
                'description' => 'Full access to all support module features',
                'permission_type' => 'custom',
            ]
        );

        // Get all support permissions
        $permissions = $this->getAllSupportPermissions();
        
        $role->permissions = array_unique(array_merge($role->permissions ?? [], $permissions));
        $role->save();

        $this->command->info('Support Admin role created/updated with full permissions.');
    }

    /**
     * Create Support Agent role with limited permissions.
     *
     * @return void
     */
    protected function createSupportAgentRole(): void
    {
        $role = Role::firstOrCreate(
            ['name' => 'Support Agent'],
            [
                'description' => 'Can view and manage tickets, add notes, but cannot delete or manage settings',
                'permission_type' => 'custom',
            ]
        );

        $permissions = [
            // Ticket permissions
            'support.tickets.view',
            'support.tickets.create',
            'support.tickets.update',
            'support.tickets.notes',
            'support.tickets.assign',
            
            // View-only for configurations
            'support.statuses.view',
            'support.priorities.view',
            'support.categories.view',
            'support.canned-responses.view',
            
            // Note and attachment permissions
            'support.notes.view',
            'support.notes.create',
            'support.attachments.view',
            'support.attachments.create',
        ];
        
        $role->permissions = array_unique(array_merge($role->permissions ?? [], $permissions));
        $role->save();

        $this->command->info('Support Agent role created/updated with agent permissions.');
    }

    /**
     * Create Support Viewer role with read-only permissions.
     *
     * @return void
     */
    protected function createSupportViewerRole(): void
    {
        $role = Role::firstOrCreate(
            ['name' => 'Support Viewer'],
            [
                'description' => 'Read-only access to support module',
                'permission_type' => 'custom',
            ]
        );

        $permissions = [
            'support.tickets.view',
            'support.statuses.view',
            'support.priorities.view',
            'support.categories.view',
            'support.canned-responses.view',
            'support.rules.view',
            'support.notes.view',
            'support.attachments.view',
        ];
        
        $role->permissions = array_unique(array_merge($role->permissions ?? [], $permissions));
        $role->save();

        $this->command->info('Support Viewer role created/updated with read-only permissions.');
    }

    /**
     * Get all support permissions from config.
     *
     * @return array
     */
    protected function getAllSupportPermissions(): array
    {
        $permissions = config('acl.permissions', []);
        
        return collect($permissions)
            ->pluck('key')
            ->filter(fn($key) => str_starts_with($key, 'support.'))
            ->values()
            ->toArray();
    }
}
