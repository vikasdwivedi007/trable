<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\PaymentMonthlyRequest;
use App\Models\User;

class PaymentMonthlyRequestPolicy
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
        return $user->hasPermission(PaymentMonthlyRequest::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PaymentMonthlyRequest  $paymentMonthlyRequest
     * @return mixed
     */
    public function view(User $user, PaymentMonthlyRequest $paymentMonthlyRequest)
    {
        return $user->hasPermission(PaymentMonthlyRequest::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(PaymentMonthlyRequest::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PaymentMonthlyRequest  $paymentMonthlyRequest
     * @return mixed
     */
    public function update(User $user, PaymentMonthlyRequest $paymentMonthlyRequest)
    {
        return $user->hasPermission(PaymentMonthlyRequest::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PaymentMonthlyRequest  $paymentMonthlyRequest
     * @return mixed
     */
    public function delete(User $user, PaymentMonthlyRequest $paymentMonthlyRequest)
    {
        return $user->hasPermission(PaymentMonthlyRequest::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PaymentMonthlyRequest  $paymentMonthlyRequest
     * @return mixed
     */
    public function restore(User $user, PaymentMonthlyRequest $paymentMonthlyRequest)
    {
        return $user->hasPermission(PaymentMonthlyRequest::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PaymentMonthlyRequest  $paymentMonthlyRequest
     * @return mixed
     */
    public function forceDelete(User $user, PaymentMonthlyRequest $paymentMonthlyRequest)
    {
        return false;
    }
}
