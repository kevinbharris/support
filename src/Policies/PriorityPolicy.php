<?php

namespace KevinBHarris\Support\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use KevinBHarris\Support\Models\Priority;

/**
 * Policy for Priority model authorization.
 * 
 * This policy integrates with Bagisto's ACL system to control access
 * to priority operations based on user permissions.
 */
class PriorityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any priorities.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function viewAny($user): bool
    {
        return $user->hasPermission('support.priorities.view');
    }

    /**
     * Determine whether the user can view the priority.
     *
     * @param  mixed  $user
     * @param  Priority  $priority
     * @return bool
     */
    public function view($user, Priority $priority): bool
    {
        return $user->hasPermission('support.priorities.view');
    }

    /**
     * Determine whether the user can create priorities.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function create($user): bool
    {
        return $user->hasPermission('support.priorities.create');
    }

    /**
     * Determine whether the user can update the priority.
     *
     * @param  mixed  $user
     * @param  Priority  $priority
     * @return bool
     */
    public function update($user, Priority $priority): bool
    {
        return $user->hasPermission('support.priorities.update');
    }

    /**
     * Determine whether the user can delete the priority.
     *
     * @param  mixed  $user
     * @param  Priority  $priority
     * @return bool
     */
    public function delete($user, Priority $priority): bool
    {
        return $user->hasPermission('support.priorities.delete');
    }
}
