<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    protected $guarded = [];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = [ 'created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $perPage = 8;

    const PERMISSION_NAME = 'Department';

    const TOURISM_DEP = 'Tourism Department';

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public static function departmentIndex()
    {
        $departments = app(Pipeline::class)->send(Department::query())
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\Active::class,
                \App\QueryFilters\Order::class,
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        return $departments->withCount('employees')->get();
    }

    public function editPath()
    {
        return route('departments.edit', ['department' => $this->id]);
    }

    public function activate()
    {
        $this->update(['active' => 1]);
        $this->employees()->update(['active' => 1]);
    }

    public function deactivate()
    {
        $this->update(['active' => 0]);
        $this->employees()->update(['active' => 0]);
    }

}
