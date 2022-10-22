<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\CashForm;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\JobFile;
use App\Models\JobTitle;
use Illuminate\Http\Request;

class CashFormController extends Controller
{
    private $prefix = 'cash-forms.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', CashForm::class);
        if (request()->ajax()) {
            $sheets = CashForm::viewIndex();
            return $sheets;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', CashForm::class);
        $job_files = JobFile::with(['guides', 'guides.guide'])->get();
        $reps = Employee::whereHas('job', function ($inner) {
            $inner->where('title', JobTitle::REPRESENTATIVE_TITLE);
        })->with('user')->get();
        return view($this->prefix . 'create', compact('reps', 'job_files'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', CashForm::class);
        CashForm::create($this->validateRequest());
        return redirect(route($this->prefix . 'index'))->with('success', __('main.cash_form_added'));
    }

    public function show(CashForm $cashForm)
    {
        $this->authorize('view', $cashForm);
        $cashForm->load(['job_file', 'job_file.guides', 'job_file.guides.guide', 'representative', 'representative.user']);
        return view($this->prefix . 'print', compact( 'cashForm'));
    }

    public function edit(CashForm $cashForm)
    {
        $this->authorize('update', $cashForm);
        $cashForm->load(['job_file', 'representative']);
        $job_files = JobFile::with(['guides', 'guides.guide'])->get();
        $reps = Employee::whereHas('job', function ($inner) {
            $inner->where('title', JobTitle::REPRESENTATIVE_TITLE);
        })->with('user')->get();
        return view($this->prefix . 'edit', compact('reps', 'job_files', 'cashForm'));
    }

    public function update(Request $request, CashForm $cashForm)
    {
        $this->authorize('update', $cashForm);
        $cashForm->update($this->validateRequest());
        return redirect(route($this->prefix . 'index'))->with('success', __('main.cash_form_updated'));
    }

    public function destroy(CashForm $cashForm)
    {
        $this->authorize('delete', $cashForm);
        $cashForm->delete();
        return redirect(route($this->prefix . 'index'))->with('success', __("main.cash_form_deleted"));
    }


    private function validateRequest()
    {
        $rules = [
            'date' => 'required|date_format:l d F Y',
            'job_id' => 'required|exists:job_files,id',
            'emp_id' => 'required|exists:employees,id',
            'additional_fees' => 'required|numeric',
            'additional_desc' => 'required'
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
