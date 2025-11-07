<?php

namespace KevinBHarris\Support\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use KevinBHarris\Support\Models\Status;

/**
 * Policy for Status model authorization.
 * 
 * This policy integrates with Bagisto's ACL system to control access
 * to status operations based on user permissions.
 */
class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any statuses.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function viewAny($user): bool
    {
        return $user->hasPermission('support.statuses.view');
    }

    /**
     * Determine whether the user can view the status.
     *
     * @param  mixed  $user
     * @param  Status  $status
     * @return bool
     */
    public function view($user, Status $status): bool
    {
        return $user->hasPermission('support.statuses.view');
    }

    /**
     * Determine whether the user can create statuses.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function create($user): bool
    {
        return $user->hasPermission('support.statuses.create');
    }

    /**
     * Determine whether the user can update the status.
     *
     * @param  mixed  $user
     * @param  Status  $status
     * @return bool
     */
    public function update($user, Status $status): bool
    {
        return $user->hasPermission('support.statuses.update');
    }

    /**
     * Determine whether the user can delete the status.
     *
     * @param  mixed  $user
     * @param  Status  $status
     * @return bool
     */
    public function delete($user, Status $status): bool
    {
        return $user->hasPermission('support.statuses.delete');
    }
}
