<?php

namespace KevinBHarris\Support\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use KevinBHarris\Support\Models\Category;

/**
 * Policy for Category model authorization.
 * 
 * This policy integrates with Bagisto's ACL system to control access
 * to category operations based on user permissions.
 */
class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any categories.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function viewAny($user): bool
    {
        return $user->hasPermission('support.categories.view');
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param  mixed  $user
     * @param  Category  $category
     * @return bool
     */
    public function view($user, Category $category): bool
    {
        return $user->hasPermission('support.categories.view');
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function create($user): bool
    {
        return $user->hasPermission('support.categories.create');
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  mixed  $user
     * @param  Category  $category
     * @return bool
     */
    public function update($user, Category $category): bool
    {
        return $user->hasPermission('support.categories.update');
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  mixed  $user
     * @param  Category  $category
     * @return bool
     */
    public function delete($user, Category $category): bool
    {
        return $user->hasPermission('support.categories.delete');
    }
}
