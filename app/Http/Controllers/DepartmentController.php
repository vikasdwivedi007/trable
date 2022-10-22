<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{

    private $prefix = 'departments.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Department::class);
        $departments = Department::departmentIndex();
        return view($this->prefix . 'index', compact('departments'));
    }

    public function create()
    {
        $this->authorize('create', Department::class);
        return view($this->prefix . 'create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Department::class);
        $department = Department::create($this->validateRequest());
        return redirect(route($this->prefix . 'index'))->with('success', __('main.department_added'));
    }

    public function edit(Department $department)
    {
        $this->authorize('update', $department);
        return view($this->prefix . 'edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $this->authorize('update', $department);
        $department->update($this->validateRequest(['name']));
        return redirect(route($this->prefix . 'index'))->with('success', __('main.department_updated'));
    }

    public function activate(Department $department)
    {
        $this->authorize('update', $department);
        if (!$department->active) {
            $department->activate();
        }
        return redirect(route($this->prefix . 'index'))
            ->with('success', __('main.department_activated'));
    }

    public function deactivate(Department $department)
    {
        $this->authorize('update', $department);
        if ($department->active) {
            $department->deactivate();
        }
        return redirect(route($this->prefix . 'index'))
            ->with('success', __('main.department_deactivated'));
    }


    private function validateRequest($only = [])
    {
        $rules = [
            'name' => 'required',
        ];
        if ($only) {
            $rules = Arr::only($rules, $only);
        }

        return request()->validate($rules);
    }
}
