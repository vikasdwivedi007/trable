<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopPolicy
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
        return $user->hasPermission(Shop::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shop  $shop
     * @return mixed
     */
    public function view(User $user, Shop $shop)
    {
        return $user->hasPermission(Shop::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(Shop::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shop  $shop
     * @return mixed
     */
    public function update(User $user, Shop $shop)
    {
        return $user->hasPermission(Shop::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shop  $shop
     * @return mixed
     */
    public function delete(User $user, Shop $shop)
    {
        return ($user->hasPermission(Shop::PERMISSION_NAME, 'write') && $shop->canBeDeleted());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shop  $shop
     * @return mixed
     */
    public function restore(User $user, Shop $shop)
    {
        return $user->hasPermission(Shop::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shop  $shop
     * @return mixed
     */
    public function forceDelete(User $user, Shop $shop)
    {
        return false;
    }
}
