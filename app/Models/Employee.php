<?php

namespace App\Models;

use App\Helpers;
use App\Mail\EmployeeWelcomeEmail;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    protected $guarded = [];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $to_be_created_user_data;
    public $to_be_created_job_data;

    const PERMISSION_NAME = 'Employee';

    public $can_search_by = ['user.name', 'user.email', 'user.phone', 'job.title', 'user.address', 'department.name'];

    protected $dates = ['hired_at', 'promoted_at'];

    protected $casts = [
        'hired_at' => 'date:Y-m-d',
        'promoted_at' => 'date:Y-m-d'
    ];

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($employee) { // before delete() method call this
            if($employee->user){
                $employee->user->delete();
            }
        });

        self::restoring(function ($employee) { // before restore() method call this
            $employee->user()->onlyTrashed()->first()->restore();
        });

        self::creating(function ($employee) {
            if ($employee->to_be_created_user_data) {
                $user = new User;
                foreach ($employee->to_be_created_user_data as $key => $value) {
                    $user->{$key} = $value;
                }
                $generated_password = Str::random(20);
                $employee->to_be_created_user_data['password_before_hash'] = $generated_password;
                $user->password = $employee->to_be_created_user_data['password_before_hash'];
                $user->save();
                $employee->user_id = $user->id;
            }
        });

        self::updating(function ($employee) {
            if ($employee->to_be_created_user_data) {
                foreach ($employee->to_be_created_user_data as $key => $value) {
                    if ($key != 'password_before_hash') {
                        if ($key == 'password') {
                            if ($employee->to_be_created_user_data['password_before_hash'] != $employee->user->password) {
                                $employee->user->{$key} = $value;
                            }
                        } else {
                            $employee->user->{$key} = $value;
                        }
                    }
                }
                $employee->user->save();
            }
        });
    }

    public function setNameAttribute($name)
    {
        $this->to_be_created_user_data['name'] = $name;
    }

    public function setNameArAttribute($name_ar)
    {
        $this->to_be_created_user_data['name_ar'] = $name_ar;
    }

    public function setPhoneAttribute($phone)
    {
        $this->to_be_created_user_data['phone'] = $phone;
    }

    public function setEmailAttribute($email)
    {
        $this->to_be_created_user_data['email'] = $email;
    }

    public function setAddressAttribute($address)
    {
        $this->to_be_created_user_data['address'] = $address;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(JobTitle::class, 'supervisor_id');
    }

    public function team()
    {
        $team = Employee::where('supervisor_id', $this->job_id)->get();
        return $team;
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function guide()
    {
        return $this->hasOne(Guide::class, 'employee_id');
    }

    public function operating_statements()
    {
        return $this->hasMany(OperatingStatement::class, 'emp_id');
    }

    public static function employeeIndex()
    {
        $query = Employee::select([
            'employees.*',
            'user.name as user.name',
            'user.email as user.email',
            'user.phone as user.phone',
            'user.address as user.address',
            'department.name as department.name',
            'job.title as job.title',
        ])->join('users as user', 'employees.user_id', '=', 'user.id')
            ->leftJoin('job_titles as job', 'employees.job_id', '=', 'job.id')
            //return all employees and if they have department_id, return it too
            ->leftJoin('departments as department', 'employees.department_id', '=', 'department.id');

        $employees = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Active::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();

        //don't show admins
        $employees->whereDoesntHave('user.roles', function ($q) {
            $q->where('name', 'admin');
        });
        //don't show self
        $employees->where('employees.id', '!=', auth()->user()->employee->id);

        //don't show suppliers-guides
        $employees->whereHas('job',function($q){
            $q->where('title', '!=', JobTitle::GUIDE_TITLE);
        });

        $count = $employees->count();//count total before applying take&skip
        $employees = app(Pipeline::class)->send($employees)
            ->through([\App\QueryFilters\Paginate::class])
            ->thenReturn();

        $employees = $employees->with(['user', 'department', 'job', 'supervisor', 'languages'])->get();
        $employees->map->languagesToStr();
        return Helpers::FormatForDatatable($employees, $count);
    }

    public function updatePermissions($data)
    {
        if (!isset($data['permissions'])) {
            $this->user->permissions()->detach();
            return $data;
        }
        $permissions = $data['permissions'];
        $this->user->permissions()->detach();
        foreach ($permissions as $permission => $value) {
            foreach ($value as $type => $on) {
                $this->user->addPermission($permission, $type);
            }
        }
    }

    public function updateLanguages($data)
    {
        if (!isset($data['languages'])) {
            return $data;
        }
        $languages = $data['languages'];
        $this->languages()->detach();
        foreach ($languages as $language) {
            $this->languages()->attach($language);
        }
    }

    public static function formatSalary($data)
    {
        if (isset($data['salary']) && $data['salary']) {
            $data['salary'] = str_replace('EGP ', '', $data['salary']);
            $data['salary'] = str_replace(',', '', $data['salary']);
        }
        return $data;
    }

    public function languagesToStr()
    {
        $languages_str = '';
        foreach ($this->languages as $lang) {
            $languages_str .= $lang->language . ', ';
        }
        $this->languages_str = trim($languages_str, ', ');
    }

    public function editPath()
    {
        return route('employees.edit', ['employee' => $this->id]);
    }

    public function deletePath()
    {
        return route('employees.destroy', ['employee' => $this->id]);
    }

    //job title
    public function job()
    {
        return $this->belongsTo(JobTitle::class, 'job_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'employee_languages', 'employee_id', 'lang_id')->withTimestamps();
    }

    public function sendWelcomeEmail()
    {
        $password_before_hash = $this->to_be_created_user_data['password_before_hash'];
        Mail::to($this->user->email)->queue(new EmployeeWelcomeEmail($this, $password_before_hash));
    }

    public function activate()
    {
        $this->active = 1;
        $this->save();
    }

    public function deactivate()
    {
        $this->active = 0;
        $this->save();
    }

    public function reminder_assigned_to_me()
    {
        return $this->hasMany(Reminder::class, 'assigned_to_id');
    }

    public function reminder_assigned_by_me()
    {
        return $this->hasMany(Reminder::class, 'assigned_by_id');
    }

    public static function getTopManagementEmployees()
    {
        return Employee::where(function ($query) {
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
            })->with('user')->get();
    }
}
