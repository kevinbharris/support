<?php

namespace KevinBHarris\Support\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use KevinBHarris\Support\Models\Attachment;

/**
 * Policy for Attachment model authorization.
 * 
 * This policy integrates with Bagisto's ACL system to control access
 * to attachment operations based on user permissions.
 */
class AttachmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any attachments.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function viewAny($user): bool
    {
        return $user->hasPermission('support.attachments.view');
    }

    /**
     * Determine whether the user can view the attachment.
     *
     * @param  mixed  $user
     * @param  Attachment  $attachment
     * @return bool
     */
    public function view($user, Attachment $attachment): bool
    {
        return $user->hasPermission('support.attachments.view');
    }

    /**
     * Determine whether the user can create attachments.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function create($user): bool
    {
        return $user->hasPermission('support.attachments.create');
    }

    /**
     * Determine whether the user can delete the attachment.
     *
     * @param  mixed  $user
     * @param  Attachment  $attachment
     * @return bool
     */
    public function delete($user, Attachment $attachment): bool
    {
        return $user->hasPermission('support.attachments.delete');
    }
}
