<?php

namespace KevinBHarris\Support\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use KevinBHarris\Support\Models\Ticket;
use KevinBHarris\Support\Models\Status;
use KevinBHarris\Support\Models\Priority;
use KevinBHarris\Support\Models\Category;
use KevinBHarris\Support\Models\CannedResponse;
use KevinBHarris\Support\Models\Rule;
use KevinBHarris\Support\Models\Note;
use KevinBHarris\Support\Models\Attachment;
use KevinBHarris\Support\Policies\TicketPolicy;
use KevinBHarris\Support\Policies\StatusPolicy;
use KevinBHarris\Support\Policies\PriorityPolicy;
use KevinBHarris\Support\Policies\CategoryPolicy;
use KevinBHarris\Support\Policies\CannedResponsePolicy;
use KevinBHarris\Support\Policies\RulePolicy;
use KevinBHarris\Support\Policies\NotePolicy;
use KevinBHarris\Support\Policies\AttachmentPolicy;

/**
 * Support Auth Service Provider
 * 
 * Registers all policies and gates for the Support module.
 * This integrates with Bagisto's ACL system.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Ticket::class => TicketPolicy::class,
        Status::class => StatusPolicy::class,
        Priority::class => PriorityPolicy::class,
        Category::class => CategoryPolicy::class,
        CannedResponse::class => CannedResponsePolicy::class,
        Rule::class => RulePolicy::class,
        Note::class => NotePolicy::class,
        Attachment::class => AttachmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->registerGates();
    }

    /**
     * Register gates for all support permissions.
     * 
     * This allows checking permissions using Gate::allows('support.tickets.view')
     * in addition to policy methods.
     * 
     * Reads from config('acl') which is expected to be a flat array of permission arrays.
     *
     * @return void
     */
    protected function registerGates(): void
    {
        // Get the flat array of permissions from config('acl')
        $permissions = config('acl', []);

        foreach ($permissions as $permission) {
            // Each permission must have a 'key' field to be registered as a gate
            // Permissions without a 'key' are silently skipped
            if (isset($permission['key'])) {
                Gate::define($permission['key'], function ($user) use ($permission) {
                    return $user->hasPermission($permission['key']);
                });
            }
        }
    }
}
