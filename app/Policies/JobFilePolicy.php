<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\Employee;
use App\Models\JobFile;
use App\Models\JobTitle;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobFilePolicy
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
        return $user->hasPermission(JobFile::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobFile  $jobFile
     * @return mixed
     */
    public function view(User $user, JobFile $jobFile)
    {
        return $user->hasPermission(JobFile::PERMISSION_NAME, 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(JobFile::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobFile  $jobFile
     * @return mixed
     */
    public function update(User $user, JobFile $jobFile)
    {
        $top_management = Employee::where(function ($query) {
            //modeer el sya7a
            $query->whereHas('department', function ($inner) {
                $inner->where('name', Department::TOURISM_DEP);
            })->whereHas('job', function ($inner) {
                $inner->where('title', JobTitle::MANAGER_TITLE);
            });
        })
            //general and vice manager
            ->orWhere(function ($query) {
                $query->whereHas('job', function ($inner) {
                    $inner->where('title', JobTitle::GENERAL_MANAGER_TITLE)->orWhere('title', JobTitle::VICE_GENERAL_MANAGER_TITLE);
                });
            })->with('user')->where('user_id', $user->id)->first();
        if(!$top_management && $jobFile->operator()->user_id != $user->id){
            return false;
        }
        return $user->hasPermission(JobFile::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobFile  $jobFile
     * @return mixed
     */
    public function delete(User $user, JobFile $jobFile)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobFile  $jobFile
     * @return mixed
     */
    public function restore(User $user, JobFile $jobFile)
    {
        return $user->hasPermission(JobFile::PERMISSION_NAME, 'write');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobFile  $jobFile
     * @return mixed
     */
    public function forceDelete(User $user, JobFile $jobFile)
    {
        return false;
    }
}
