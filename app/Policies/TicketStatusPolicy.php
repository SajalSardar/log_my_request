<?php

namespace App\Policies;

use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TicketStatusPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
         if ($user->can('ticketStatus view list')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TicketStatus $ticketStatus): bool
    {
        if ($user->can('ticketStatus view list')) {
            return true;
        }
  
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return ($user->can('ticketStatus create'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TicketStatus $ticketStatus): bool
    {
        if ($user->can('ticketStatus update')) {
            return true;
        }

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TicketStatus $ticketStatus): bool
    {
        if ($user->can('ticketStatus delete')) {
            return true;
        }

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TicketStatus $ticketStatus): bool
    {
        if ($user->can('ticketStatus restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TicketStatus $ticketStatus): bool
    {
        if ($user->can('ticketStatus force delete')) {
            return true;
        }
    }
}
