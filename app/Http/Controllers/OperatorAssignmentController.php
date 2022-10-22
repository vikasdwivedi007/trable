<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\OperatorAssignment;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Transportation;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OperatorAssignmentController extends Controller
{
    private $prefix = 'operator-assignments.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', OperatorAssignment::class);
        if (request()->ajax()) {
            $assignments = OperatorAssignment::viewIndex();
            return $assignments;
        }
        //if manager (someone who can create assignment), he will also have the ability to filter
        if (auth()->user()->can('create', OperatorAssignment::class)) {
            $operators = Employee::whereHas('job', function ($inner) {
                $inner->where('title', JobTitle::OPERATOR_TITLE);
            })->with('user')->get();
            return view($this->prefix . 'index', compact('operators'));
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', OperatorAssignment::class);
        $operators = Employee::whereHas('job', function ($inner) {
            $inner->where('title', JobTitle::OPERATOR_TITLE);
        })->with('user')->get();
        return view($this->prefix . 'create', compact('operators'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', OperatorAssignment::class);
        $data = $this->validateRequest();
        $data = OperatorAssignment::prepareData($data);
        $assignment = OperatorAssignment::create($data);
        $message = __('main.operator_assignment_added');
        if (request()->ajax()) {
            session()->flash('success', $message);
            return response()->json(['success' => true, 'message' => $message, 'redirect_to' => route($this->prefix . 'index')]);
        } else {
            return redirect(route($this->prefix . 'index'))->with('success', $message);
        }
    }

    public function edit(OperatorAssignment $operatorAssignment)
    {
        $this->authorize('update', $operatorAssignment);
        $operators = Employee::whereHas('job', function ($inner) {
            $inner->where('title', JobTitle::OPERATOR_TITLE);
        })->with('user')->get();
        $start = clone $operatorAssignment->date;
        $end = clone $operatorAssignment->date;
        $start = $start->startOfDay();
        $end = $end->endOfDay();
        $operatorAssignment->load([
            'job_file', 'job_file.travel_agent',
            'job_file.guides' => function ($inner) use ($start, $end) {
                $inner->where('date', '>=', $start)->where('date', '<=', $end);
            }, 'job_file.guides.guide', 'job_file.guides.city', 'job_file.guides.sightseeing',
            'job_file.accommodations', 'job_file.accommodations.hotel',
            'operator', 'operator.user', 'daily_sheet', 'daily_sheet.transportation', 'daily_sheet.representative', 'daily_sheet.representative.user'
        ]);
//        $daily_sheet = $operatorAssignment->job_file->getLastDailySheet($operatorAssignment->date->format('l d F Y'));
//        $last_sheet = $daily_sheet ? $daily_sheet->load(['transportation', 'representative', 'representative.user']) : null;
        return view($this->prefix . 'edit', compact('operatorAssignment', 'operators'));
    }

    public function update(Request $request, OperatorAssignment $operatorAssignment)
    {
        $this->authorize('update', $operatorAssignment);
        $data = $this->validateRequest();
        $data = OperatorAssignment::prepareData($data);
        if (isset($data['daily_sheet_id'])) {
            unset($data['daily_sheet_id']);
        }
        $operatorAssignment->update($data);
        $message = __('main.operator_assignment_updated');
        if (request()->ajax()) {
            session()->flash('success', $message);
            return response()->json(['success' => true, 'message' => $message, 'redirect_to' => route($this->prefix . 'index')]);
        } else {
            return redirect(route($this->prefix . 'index'))->with('success', $message);
        }
    }

    public function destroy(OperatorAssignment $operatorAssignment)
    {
        $this->authorize('delete', $operatorAssignment);
        $operatorAssignment->delete();
        return redirect(route($this->prefix . 'index'))->with('success', __('main.operator_assignment_deleted'));
    }

    public function review(OperatorAssignment $operatorAssignment, $status)
    {
        $this->authorize('review', $operatorAssignment);
        if (in_array($status, [0, 1, 2])) {
            $operatorAssignment->update(['status' => $status]);
        }
        return redirect(route($this->prefix . 'index'))->with('success', __('main.operator_assignment_reviewed'));
    }

    public function print()
    {
        //query:
        //date-range=20/04/2021 - 24/04/2021&emp-id=14
        $this->authorize('create', OperatorAssignment::class);
        try {
            if (request('date-range') && request('emp-id')) {
                $query = OperatorAssignment::query();
                $dates_str = request('date-range');
                $dates = explode('-', $dates_str);
                if (count($dates) == 2) {
                    $start = Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                    $end = Carbon::createFromFormat('d/m/Y', trim($dates[1]));
                    $start = $start->startOfDay();
                    $end = $end->endOfDay();
                    $query->where('date', '>=', $start)->where('date', '<=', $end);
                }
                $emp_id = request('emp-id');
                $query->where('emp_id', $emp_id);
                $operatorAssignments = $query->get();
                if (!$operatorAssignments->count()) {
                    return redirect(route($this->prefix . 'index'))->with('error', __('main.no_data_for_filter'));
                }
                $data = [];
                foreach ($operatorAssignments as $operatorAssignment) {
                    $start = clone $operatorAssignment->date;
                    $end = clone $operatorAssignment->date;
                    $start = $start->startOfDay();
                    $end = $end->endOfDay();
                    $operatorAssignment->load([
                        'job_file', 'job_file.travel_agent',
                        'job_file.guides' => function ($inner) use ($start, $end) {
                            $inner->where('date', '>=', $start)->where('date', '<=', $end);
                        }, 'job_file.guides.guide', 'job_file.guides.city', 'job_file.guides.sightseeing',
                        'job_file.accommodations', 'job_file.accommodations.hotel',
                        'operator', 'operator.user', 'daily_sheet', 'daily_sheet.transportation', 'daily_sheet.representative', 'daily_sheet.representative.user',
                    ]);
                    $data[] = $operatorAssignment;
                }
                return view($this->prefix . 'print', compact('data'));
            } else {
                return redirect(route($this->prefix . 'index'))->with('error', __('main.invalid_filter_data'));
            }
        } catch (\Throwable $t) {
            return redirect(route($this->prefix . 'index'))->with('error', __('main.server_error'));
        }
    }


    private function validateRequest()
    {
        $rules = [
            'date' => 'required|date_format:l d F Y',
            'emp_id' => 'required|exists:employees,id',
            'file_no' => 'required|exists:job_files,file_no',
            'router_number' => 'nullable',
            'remarks' => 'nullable',
            'itinerary' => 'nullable',
        ];
        return request()->validate($rules);
    }
}
