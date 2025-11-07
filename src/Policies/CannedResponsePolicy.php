<?php

namespace KevinBHarris\Support\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use KevinBHarris\Support\Models\CannedResponse;

/**
 * Policy for CannedResponse model authorization.
 * 
 * This policy integrates with Bagisto's ACL system to control access
 * to canned response operations based on user permissions.
 */
class CannedResponsePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any canned responses.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function viewAny($user): bool
    {
        return $user->hasPermission('support.canned-responses.view');
    }

    /**
     * Determine whether the user can view the canned response.
     *
     * @param  mixed  $user
     * @param  CannedResponse  $cannedResponse
     * @return bool
     */
    public function view($user, CannedResponse $cannedResponse): bool
    {
        return $user->hasPermission('support.canned-responses.view');
    }

    /**
     * Determine whether the user can create canned responses.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function create($user): bool
    {
        return $user->hasPermission('support.canned-responses.create');
    }

    /**
     * Determine whether the user can update the canned response.
     *
     * @param  mixed  $user
     * @param  CannedResponse  $cannedResponse
     * @return bool
     */
    public function update($user, CannedResponse $cannedResponse): bool
    {
        return $user->hasPermission('support.canned-responses.update');
    }

    /**
     * Determine whether the user can delete the canned response.
     *
     * @param  mixed  $user
     * @param  CannedResponse  $cannedResponse
     * @return bool
     */
    public function delete($user, CannedResponse $cannedResponse): bool
    {
        return $user->hasPermission('support.canned-responses.delete');
    }
}
