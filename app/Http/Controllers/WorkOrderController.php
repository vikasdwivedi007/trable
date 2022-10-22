<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\JobFile;
use App\Models\JobTitle;
use App\Models\WorkOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    private $prefix = 'work-orders.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', WorkOrder::class);
        if (request()->ajax()) {
            return WorkOrder::viewIndex();
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', WorkOrder::class);
        $reps = Employee::whereHas('job', function ($inner) {
            $inner->where('title', JobTitle::REPRESENTATIVE_TITLE);
        })->with('user')->get();
        $job_files = JobFile::with(['country', 'airport_to'])->get();
        foreach($job_files as $job_file){
            $job_file->airport_to_formatted = $job_file->airport_to->format();
        }
        return view($this->prefix . 'create', compact('reps', 'job_files'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', WorkOrder::class);
        $data = $this->validateRequest();
        $order = WorkOrder::create($data);
        return redirect(route($this->prefix . 'index'))->with('success', __("main.work_order_added"));
    }

    public function show(WorkOrder $workOrder)
    {
        $this->authorize('create', $workOrder);
        $workOrder->load(['job_file', 'job_file.country', 'job_file.airport_to', 'representative', 'representative.user']);
        $workOrder->job_file->airport_to_formatted = $workOrder->job_file->airport_to->format();
        return view($this->prefix . 'print', compact('workOrder'));
    }

    public function edit(WorkOrder $workOrder)
    {
        $this->authorize('create', $workOrder);
        $workOrder->load(['job_file', 'representative']);
        $job_files = JobFile::with(['country', 'airport_to'])->get();
        foreach($job_files as $job_file){
            $job_file->airport_to_formatted = $job_file->airport_to->format();
        }
        $reps = Employee::whereHas('job', function ($inner) {
            $inner->where('title', JobTitle::REPRESENTATIVE_TITLE);
        })->with('user')->get();
        return view($this->prefix . 'edit', compact('workOrder', 'reps', 'job_files'));
    }

    public function update(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('create', $workOrder);
        $data = $this->validateRequest();
        $workOrder->update($data);
        return redirect(route($this->prefix . 'index'))->with('success', __("main.work_order_updated"));
    }

    public function destroy(WorkOrder $workOrder)
    {
        $this->authorize('delete', $workOrder);
        $workOrder->delete();
        return redirect(route($this->prefix . 'index'))->with('success', __("main.work_order_deleted"));
    }


    private function validateRequest()
    {
        $rules = [
            'date' => 'required|date_format:l d F Y',
            'job_id' => 'required|exists:job_files,id',
            'emp_id' => 'required|exists:employees,id'
        ];
        return request()->validate($rules);
    }
}
