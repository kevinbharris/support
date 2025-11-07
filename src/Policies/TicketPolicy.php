<?php

namespace KevinBHarris\Support\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use KevinBHarris\Support\Models\Ticket;

/**
 * Policy for Ticket model authorization.
 * 
 * This policy integrates with Bagisto's ACL system to control access
 * to ticket operations based on user permissions.
 */
class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tickets.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function viewAny($user): bool
    {
        return $user->hasPermission('support.tickets.view');
    }

    /**
     * Determine whether the user can view the ticket.
     *
     * @param  mixed  $user
     * @param  Ticket  $ticket
     * @return bool
     */
    public function view($user, Ticket $ticket): bool
    {
        return $user->hasPermission('support.tickets.view');
    }

    /**
     * Determine whether the user can create tickets.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function create($user): bool
    {
        return $user->hasPermission('support.tickets.create');
    }

    /**
     * Determine whether the user can update the ticket.
     *
     * @param  mixed  $user
     * @param  Ticket  $ticket
     * @return bool
     */
    public function update($user, Ticket $ticket): bool
    {
        return $user->hasPermission('support.tickets.update');
    }

    /**
     * Determine whether the user can delete the ticket.
     *
     * @param  mixed  $user
     * @param  Ticket  $ticket
     * @return bool
     */
    public function delete($user, Ticket $ticket): bool
    {
        return $user->hasPermission('support.tickets.delete');
    }

    /**
     * Determine whether the user can assign tickets.
     *
     * @param  mixed  $user
     * @param  Ticket  $ticket
     * @return bool
     */
    public function assign($user, Ticket $ticket): bool
    {
        return $user->hasPermission('support.tickets.assign');
    }

    /**
     * Determine whether the user can add notes to tickets.
     *
     * @param  mixed  $user
     * @param  Ticket  $ticket
     * @return bool
     */
    public function addNote($user, Ticket $ticket): bool
    {
        return $user->hasPermission('support.tickets.notes');
    }

    /**
     * Determine whether the user can manage watchers.
     *
     * @param  mixed  $user
     * @param  Ticket  $ticket
     * @return bool
     */
    public function manageWatchers($user, Ticket $ticket): bool
    {
        return $user->hasPermission('support.tickets.watchers');
    }
}
