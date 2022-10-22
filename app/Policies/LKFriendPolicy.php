<?php

namespace App\Policies;

use App\Models\LKFriend;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LKFriendPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission(LKFriend::PERMISSION_NAME, 'read');

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\LKFriend $lKFriend
     * @return mixed
     */
    public function view(User $user, LKFriend $lKFriend)
    {
        return $user->hasPermission(LKFriend::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(LKFriend::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\LKFriend $lKFriend
     * @return mixed
     */
    public function update(User $user, LKFriend $lKFriend)
    {
        return $user->hasPermission(LKFriend::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\LKFriend $lKFriend
     * @return mixed
     */
    public function delete(User $user, LKFriend $lKFriend)
    {
        return ($user->hasPermission(LKFriend::PERMISSION_NAME, 'write') && $lKFriend->canBeDeleted());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\LKFriend $lKFriend
     * @return mixed
     */
    public function restore(User $user, LKFriend $lKFriend)
    {
        return $user->hasPermission(LKFriend::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\LKFriend $lKFriend
     * @return mixed
     */
    public function forceDelete(User $user, LKFriend $lKFriend)
    {
        return false;
    }
}
