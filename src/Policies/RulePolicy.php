<?php

namespace KevinBHarris\Support\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use KevinBHarris\Support\Models\Rule;

/**
 * Policy for Rule model authorization.
 * 
 * This policy integrates with Bagisto's ACL system to control access
 * to rule operations based on user permissions.
 */
class RulePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any rules.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function viewAny($user): bool
    {
        return $user->hasPermission('support.rules.view');
    }

    /**
     * Determine whether the user can view the rule.
     *
     * @param  mixed  $user
     * @param  Rule  $rule
     * @return bool
     */
    public function view($user, Rule $rule): bool
    {
        return $user->hasPermission('support.rules.view');
    }

    /**
     * Determine whether the user can create rules.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function create($user): bool
    {
        return $user->hasPermission('support.rules.create');
    }

    /**
     * Determine whether the user can update the rule.
     *
     * @param  mixed  $user
     * @param  Rule  $rule
     * @return bool
     */
    public function update($user, Rule $rule): bool
    {
        return $user->hasPermission('support.rules.update');
    }

    /**
     * Determine whether the user can delete the rule.
     *
     * @param  mixed  $user
     * @param  Rule  $rule
     * @return bool
     */
    public function delete($user, Rule $rule): bool
    {
        return $user->hasPermission('support.rules.delete');
    }
}
