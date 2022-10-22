<?php

namespace App\Policies;

use App\Models\Sightseeing;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SightseeingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission(Sightseeing::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sightseeing  $sightseeing
     * @return mixed
     */
    public function view(User $user, Sightseeing $sightseeing)
    {
        return $user->hasPermission(Sightseeing::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(Sightseeing::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sightseeing  $sightseeing
     * @return mixed
     */
    public function update(User $user, Sightseeing $sightseeing)
    {
        return $user->hasPermission(Sightseeing::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sightseeing  $sightseeing
     * @return mixed
     */
    public function delete(User $user, Sightseeing $sightseeing)
    {
        return ($user->hasPermission(Sightseeing::PERMISSION_NAME, 'write') && $sightseeing->canBeDeleted());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sightseeing  $sightseeing
     * @return mixed
     */
    public function restore(User $user, Sightseeing $sightseeing)
    {
        return $user->hasPermission(Sightseeing::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sightseeing  $sightseeing
     * @return mixed
     */
    public function forceDelete(User $user, Sightseeing $sightseeing)
    {
        return false;
    }
}
