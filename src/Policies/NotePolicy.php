<?php

namespace KevinBHarris\Support\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use KevinBHarris\Support\Models\Note;

/**
 * Policy for Note model authorization.
 * 
 * This policy integrates with Bagisto's ACL system to control access
 * to note operations based on user permissions.
 */
class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any notes.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function viewAny($user): bool
    {
        return $user->hasPermission('support.notes.view');
    }

    /**
     * Determine whether the user can view the note.
     *
     * @param  mixed  $user
     * @param  Note  $note
     * @return bool
     */
    public function view($user, Note $note): bool
    {
        return $user->hasPermission('support.notes.view');
    }

    /**
     * Determine whether the user can create notes.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function create($user): bool
    {
        return $user->hasPermission('support.notes.create');
    }

    /**
     * Determine whether the user can delete the note.
     *
     * @param  mixed  $user
     * @param  Note  $note
     * @return bool
     */
    public function delete($user, Note $note): bool
    {
        return $user->hasPermission('support.notes.delete');
    }
}
