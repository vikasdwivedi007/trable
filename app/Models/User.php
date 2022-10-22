<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable, CanResetPassword, SoftDeletes, LogsActivity, SerializeDate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'profile_pic'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['password', 'created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public function setDepartmentIdAttribute($department_id)
    {
        $this->employee->department_id = $department_id;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function setProfilePicAttribute($profile_pic)
    {
        $data = File::uploadFile($profile_pic, 'profile_pics', $this->id);
        logger($data);
        $this->attributes['profile_pic'] = $data['url'];
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id')->withPivot('read', 'write')->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->roles()->where('name', 'admin')->count();
    }

    public function addPermission($permission, $types)
    {
        if (!is_array($types)) {
            $types = [$types];
        }
        $permission = Permission::where('name', $permission)->first();
        if ($permission) {
            foreach ($types as $type) {
                if (!$this->hasPermission($permission->name, $type)) {
                    $this->permissions()->attach($permission->id, [$type => 1]);
                }
            }
        }
    }

    public function removePermission($permission, $types)
    {
        if (!is_array($types)) {
            $types = [$types];
        }
        foreach ($types as $type) {
            $this->permissions()->where('name', $permission)->wherePivot($type, '=', 1)->detach();
        }
    }

    /*
     * if admin or has any permission (r or w) on a model or has specific permission on a model
     * $param $permission (name of the model)
     * $param $type (read or write)
     * @return bool
     */
    public function hasPermission($permission, $type = '')
    {
        return $this->isAdmin() || (!$type && $this->permissions()->where('name', $permission)->count()) || ($type && $this->permissions()->where('name', $permission)->wherePivot($type, 1)->count());
    }

    /*
     * mainly to find if user has any permission from array of permissions
     * if admin or has any permission (r or w) on a model or has specific permission on a model
     * $param $permission (name of the model)
     * $param $type (read or write)
     * @return bool
     */
    public function hasAnyPermission($permissions, $type = '')
    {
        foreach ($permissions as $permission) {
            $has = $this->isAdmin() || (!$type && $this->permissions()->where('name', $permission)->count()) || ($type && $this->permissions()->where('name', $permission)->wherePivot($type, 1)->count());
            if ($has) {
                return true;
            }
        }
        return false;
    }

}
