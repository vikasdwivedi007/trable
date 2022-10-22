<?php

namespace App\Policies;

use App\Models\Guide;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GuidePolicy
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
        return $user->hasPermission(Guide::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Guide  $guide
     * @return mixed
     */
    public function view(User $user, Guide $guide)
    {
        return $user->hasPermission(Guide::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(Guide::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Guide  $guide
     * @return mixed
     */
    public function update(User $user, Guide $guide)
    {
        return $user->hasPermission(Guide::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Guide  $guide
     * @return mixed
     */
    public function delete(User $user, Guide $guide)
    {
        return ($user->hasPermission(Guide::PERMISSION_NAME, 'write') && $guide->canBeDeleted());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Guide  $guide
     * @return mixed
     */
    public function restore(User $user, Guide $guide)
    {
        return $user->hasPermission(Guide::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Guide  $guide
     * @return mixed
     */
    public function forceDelete(User $user, Guide $guide)
    {
        return false;
    }
}
