<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\ActivityLog;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ActivityLogController extends Controller
{

    private $prefix = 'activity-logs.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', ActivityLog::class);
        if(request()->ajax()){
            $logs = ActivityLog::logsIndex();
            return $logs;
        }
        return view($this->prefix.'index');
    }
}
