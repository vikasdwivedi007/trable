<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Employee;
use App\Models\JobFile;
use App\Models\JobTitle;
use App\Models\OperatingStatement;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OperatingStatementController extends Controller
{
    private $prefix = 'operating-statements.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', OperatingStatement::class);
        if (request()->ajax()) {
            $operating_statements = OperatingStatement::viewIndex();
            return $operating_statements;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', OperatingStatement::class);
        $job_files = JobFile::orderBy('created_at', 'DESC')->get();
        $employees = Employee::whereHas('job', function ($inner) {
            $inner->where('title', JobTitle::REPRESENTATIVE_TITLE);
        })->with('user')->get();
        return view($this->prefix . 'create', compact('job_files', 'employees'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', OperatingStatement::class);
        OperatingStatement::create($this->validateRequest());
        return redirect(route($this->prefix . 'index'))->with('success', __('main.operating_statement_added'));
    }

    public function print()
    {
        if (request('month') && request('year')) {
            $date_str = '01-' . request('month') . '-' . request('year');
            $date = Carbon::createFromFormat('d-m-Y', $date_str);
            $data = OperatingStatement::getOperatingMonthlyReport($date);
            if (!$data) {
                return redirect(route($this->prefix . 'index'))->with('error', __('main.no_data_for_selected_date') . ' ' . $date_str);
            }
            return view($this->prefix . 'print', compact('data', 'date'));
        } else {
            return redirect(route($this->prefix . 'index'))->with('error', __('main.missing_month_year_data'));
        }
    }

    public function edit(OperatingStatement $operatingStatement)
    {
        $this->authorize('update', $operatingStatement);
        $job_files = JobFile::orderBy('created_at', 'DESC')->get();
        $employees = Employee::whereHas('job', function ($inner) {
            $inner->where('title', JobTitle::REPRESENTATIVE_TITLE);
        })->with('user')->get();
        return view($this->prefix . 'edit', compact('operatingStatement', 'job_files', 'employees'));
    }

    public function update(Request $request, OperatingStatement $operatingStatement)
    {
        $this->authorize('update', $operatingStatement);
        $operatingStatement->update($this->validateRequest());
        return redirect(route($this->prefix . 'index'))->with('success', __('main.operating_statement_updated'));
    }

    public function destroy(OperatingStatement $operatingStatement)
    {
        $this->authorize('delete', $operatingStatement);
        $operatingStatement->delete();
        return redirect(route($this->prefix . 'index'))->with('success', __('main.operating_statement_deleted'));
    }


    private function validateRequest()
    {
        $rules = [
            'date' => 'required|date_format:l d F Y',
            'job_id' => 'required|exists:job_files,id',
            'emp_id' => 'required|exists:employees,id',
        ];
        return request()->validate($rules);
    }
}
