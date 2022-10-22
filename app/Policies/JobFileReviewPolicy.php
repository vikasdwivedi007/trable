<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\JobFileReview;
use App\Models\User;

class JobFileReviewPolicy
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
        return $user->hasPermission(JobFileReview::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobFileReview  $jobFileReview
     * @return mixed
     */
    public function view(User $user, JobFileReview $jobFileReview)
    {
        return $user->hasPermission(JobFileReview::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(JobFileReview::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobFileReview  $jobFileReview
     * @return mixed
     */
    public function update(User $user, JobFileReview $jobFileReview)
    {
        return $user->hasPermission(JobFileReview::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobFileReview  $jobFileReview
     * @return mixed
     */
    public function delete(User $user, JobFileReview $jobFileReview)
    {
        return $user->hasPermission(JobFileReview::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobFileReview  $jobFileReview
     * @return mixed
     */
    public function restore(User $user, JobFileReview $jobFileReview)
    {
        return $user->hasPermission(JobFileReview::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobFileReview  $jobFileReview
     * @return mixed
     */
    public function forceDelete(User $user, JobFileReview $jobFileReview)
    {
        return false;
    }
}
