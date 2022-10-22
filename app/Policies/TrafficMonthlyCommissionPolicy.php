<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\TrafficMonthlyCommission;
use App\Models\User;

class TrafficMonthlyCommissionPolicy
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
        return $user->hasPermission(TrafficMonthlyCommission::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TrafficMonthlyCommission  $trafficMonthlyCommission
     * @return mixed
     */
    public function view(User $user, TrafficMonthlyCommission $trafficMonthlyCommission)
    {
        return $user->hasPermission(TrafficMonthlyCommission::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(TrafficMonthlyCommission::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TrafficMonthlyCommission  $trafficMonthlyCommission
     * @return mixed
     */
    public function update(User $user, TrafficMonthlyCommission $trafficMonthlyCommission)
    {
        return $user->hasPermission(TrafficMonthlyCommission::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TrafficMonthlyCommission  $trafficMonthlyCommission
     * @return mixed
     */
    public function delete(User $user, TrafficMonthlyCommission $trafficMonthlyCommission)
    {
        return $user->hasPermission(TrafficMonthlyCommission::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TrafficMonthlyCommission  $trafficMonthlyCommission
     * @return mixed
     */
    public function restore(User $user, TrafficMonthlyCommission $trafficMonthlyCommission)
    {
        return $user->hasPermission(TrafficMonthlyCommission::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TrafficMonthlyCommission  $trafficMonthlyCommission
     * @return mixed
     */
    public function forceDelete(User $user, TrafficMonthlyCommission $trafficMonthlyCommission)
    {
        return false;
    }
}
