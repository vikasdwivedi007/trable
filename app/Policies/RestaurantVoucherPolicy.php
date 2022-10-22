<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\RestaurantVoucher;
use App\Models\User;

class RestaurantVoucherPolicy
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
        return $user->hasPermission(RestaurantVoucher::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RestaurantVoucher  $restaurantVoucher
     * @return mixed
     */
    public function view(User $user, RestaurantVoucher $restaurantVoucher)
    {
        return $user->hasPermission(RestaurantVoucher::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(RestaurantVoucher::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RestaurantVoucher  $restaurantVoucher
     * @return mixed
     */
    public function update(User $user, RestaurantVoucher $restaurantVoucher)
    {
        return $user->hasPermission(RestaurantVoucher::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RestaurantVoucher  $restaurantVoucher
     * @return mixed
     */
    public function delete(User $user, RestaurantVoucher $restaurantVoucher)
    {
        return $user->hasPermission(RestaurantVoucher::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RestaurantVoucher  $restaurantVoucher
     * @return mixed
     */
    public function restore(User $user, RestaurantVoucher $restaurantVoucher)
    {
        return $user->hasPermission(RestaurantVoucher::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RestaurantVoucher  $restaurantVoucher
     * @return mixed
     */
    public function forceDelete(User $user, RestaurantVoucher $restaurantVoucher)
    {
        return false;
    }
}
