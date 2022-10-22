<?php

namespace App\Policies;

use App\Models\TravelAgent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TravelAgentPolicy
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
        return $user->hasPermission(TravelAgent::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TravelAgent  $travel_agent
     * @return mixed
     */
    public function view(User $user, TravelAgent $travel_agent)
    {
        return $user->hasPermission(TravelAgent::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(TravelAgent::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TravelAgent  $travel_agent
     * @return mixed
     */
    public function update(User $user, TravelAgent $travel_agent)
    {
        return $user->hasPermission(TravelAgent::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TravelAgent  $travel_agent
     * @return mixed
     */
    public function delete(User $user, TravelAgent $travel_agent)
    {
        return ($user->hasPermission(TravelAgent::PERMISSION_NAME, 'write') && $travel_agent->canBeDeleted());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TravelAgent  $travel_agent
     * @return mixed
     */
    public function restore(User $user, TravelAgent $travel_agent)
    {
        return $user->hasPermission(TravelAgent::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TravelAgent  $travel_agent
     * @return mixed
     */
    public function forceDelete(User $user, TravelAgent $travel_agent)
    {
        return false;
    }
}
