<?php

namespace App\Policies;

use App\Models\Transportation;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\PolicePermission;
use App\Models\User;

class PolicePermissionPolicy
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
        return $user->hasPermission(PolicePermission::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PolicePermission  $policePermission
     * @return mixed
     */
    public function view(User $user, PolicePermission $policePermission)
    {
        return $user->hasPermission(PolicePermission::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(PolicePermission::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PolicePermission  $policePermission
     * @return mixed
     */
    public function update(User $user, PolicePermission $policePermission)
    {
        return $user->hasPermission(PolicePermission::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PolicePermission  $policePermission
     * @return mixed
     */
    public function delete(User $user, PolicePermission $policePermission)
    {
        return $user->hasPermission(PolicePermission::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PolicePermission  $policePermission
     * @return mixed
     */
    public function restore(User $user, PolicePermission $policePermission)
    {
        return $user->hasPermission(PolicePermission::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PolicePermission  $policePermission
     * @return mixed
     */
    public function forceDelete(User $user, PolicePermission $policePermission)
    {
        return false;
    }
}
