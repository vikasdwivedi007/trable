<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\OperatorAssignment;
use App\Models\User;

class OperatorAssignmentPolicy
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
        return $user->hasPermission(OperatorAssignment::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\OperatorAssignment $operatorAssignment
     * @return mixed
     */
    public function view(User $user, OperatorAssignment $operatorAssignment)
    {
        return $user->hasPermission(OperatorAssignment::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(OperatorAssignment::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\OperatorAssignment $operatorAssignment
     * @return mixed
     */
    public function update(User $user, OperatorAssignment $operatorAssignment)
    {
        return $user->hasPermission(OperatorAssignment::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\OperatorAssignment $operatorAssignment
     * @return mixed
     */
    public function delete(User $user, OperatorAssignment $operatorAssignment)
    {
        return $user->hasPermission(OperatorAssignment::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\OperatorAssignment $operatorAssignment
     * @return mixed
     */
    public function restore(User $user, OperatorAssignment $operatorAssignment)
    {
        return $user->hasPermission(OperatorAssignment::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\OperatorAssignment $operatorAssignment
     * @return mixed
     */
    public function forceDelete(User $user, OperatorAssignment $operatorAssignment)
    {
        return false;
    }

    public function review(User $user, OperatorAssignment $operatorAssignment)
    {
        return $user->employee->id == $operatorAssignment->emp_id;
    }
}
