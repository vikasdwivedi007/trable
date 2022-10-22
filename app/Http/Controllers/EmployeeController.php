<?php

namespace App\Http\Controllers;

use App\Helpers;
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

class EmployeeController extends Controller
{

    private $prefix = 'employees.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Employee::class);
        if(request()->ajax()){
            $employees = Employee::employeeIndex();
            return $employees;
        }
        return view($this->prefix.'index');
    }

    public function create()
    {
        $this->authorize('create', Employee::class);
        $departments = Department::where('active', 1)->get();
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        $languages = Language::all();
        $job_titles = JobTitle::where('can_be_assigned', 1)->get();
        $permissions = Permission::all();
        $available_supervisors = JobTitle::whereIn('title', JobTitle::managers_titles())->get();
        return view($this->prefix . 'create', compact('departments', 'cities', 'languages', 'job_titles', 'permissions', 'available_supervisors'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Employee::class);
        $data = JobTitle::handleJobIdAndTitle($this->validateRequest());
        $employee = Employee::create(Arr::except($data, ['permissions', 'languages']));
        $employee->updatePermissions($data);
        $employee->updateLanguages($data);
        $employee->sendWelcomeEmail();

        return redirect(route($this->prefix . 'index'))->with('success', __('main.employee_added'));
    }

    public function edit(Employee $employee)
    {
        $this->authorize('update', $employee);
        $departments = Department::where('active', 1)->get();
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        $languages = Language::all();
        $job_titles = JobTitle::where('can_be_assigned', 1)->get();
        $permissions = Permission::all();
        $available_supervisors = JobTitle::whereIn('title', JobTitle::managers_titles())->get();
        $employee->load(['user', 'user.permissions', 'department', 'job', 'supervisor', 'languages']);
        return view($this->prefix . 'edit', compact('employee', 'departments', 'cities', 'languages', 'job_titles', 'permissions', 'available_supervisors'));
    }

    public function update(Request $request, Employee $employee)
    {
        $this->authorize('update', $employee);
        $employee->load('user');
        $data = JobTitle::handleJobIdAndTitle($this->validateRequest($employee));
        $employee->update(Arr::except($data, ['permissions', 'languages']));
        $employee->updatePermissions($data);
        $employee->updateLanguages($data);
        return redirect(route($this->prefix . 'index'))->with('success', __('main.employee_updated'));
    }

//    public function destroy(Employee $employee)
//    {
//        $this->authorize('delete', $employee);
//        $employee->load('user');
//        //emp->user gets deleted in Model boot
//        $employee->delete();
//        return redirect(route($this->prefix . 'index'))->with('success', "Employee deleted successfully");
//    }

    public function activate(Employee $employee)
    {
        $this->authorize('update', $employee);
        $employee->load('user');
        $employee->activate();
        return redirect(route($this->prefix . 'index'))->with('success', __('main.employee_activated'));
    }

    public function deactivate(Employee $employee)
    {
        $this->authorize('update', $employee);
        $employee->load('user');
        $employee->deactivate();
        return redirect(route($this->prefix . 'index'))->with('success', __('main.employee_deactivated'));
    }


    private function validateRequest($employee = null)
    {
        $rules = [
            'name' => 'required|string|min:4',
            'name_ar' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric',
            'address' => 'required',
            'job_title' => 'required_without:job_id',
            'job_id' => ['required_without:job_title', 'nullable', 'exists:job_titles,id'],
            'languages' => 'required|array',
            'languages.*' => 'required|exists:languages,id',
            'salary' => 'numeric',
            'points' => 'nullable|numeric',
            'commission' => 'numeric',
            'department_id' => 'required|exists:departments,id',
            'supervisor_id' => 'nullable|exists:job_titles,id',
            'gender' => ['required', Rule::in([0, 1])],
            'outsource' => ['required', Rule::in([0, 1])], //0 male, 1 female
            'hired_at' => 'nullable|date|before:now,date_format:Y-m-d',
            'promoted_at' => 'nullable|date|before:now,date_format:Y-m-d',
            'city_id' => 'required|exists:cities,id',
            'permissions' => 'array',
            'permissions.*' => 'array'
        ];
        //prevent anyone from having the job of the general manager
        $general_manager_job = JobTitle::where('title', JobTitle::GENERAL_MANAGER_TITLE)->first();
        if ($general_manager_job) {
            $rules['job_id'][] = Rule::notIn([$general_manager_job->id]);
        }
        if ($employee) {
            $rules['email'] = 'required|email|unique:users,email,' . $employee->user->id;
        }
        Helpers::removeCurrencyFromNumericFields($rules);
        Helpers::formatEmployeeRequestParams();
        return request()->validate($rules);
    }
}
