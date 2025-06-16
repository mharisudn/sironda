<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PollingCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class PollingCodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_polling::code');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PollingCode $pollingCode): bool
    {
        return $user->can('view_polling::code');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_polling::code');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PollingCode $pollingCode): bool
    {
        return $user->can('update_polling::code');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PollingCode $pollingCode): bool
    {
        return $user->can('delete_polling::code');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_polling::code');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PollingCode $pollingCode): bool
    {
        return $user->can('force_delete_polling::code');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_polling::code');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, PollingCode $pollingCode): bool
    {
        return $user->can('restore_polling::code');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_polling::code');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, PollingCode $pollingCode): bool
    {
        return $user->can('replicate_polling::code');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_polling::code');
    }
}
