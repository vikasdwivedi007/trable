<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\JobFile;
use App\Models\TrafficMonthlyCommission;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrafficMonthlyCommissionController extends Controller
{
    private $prefix = 'traffic-monthly-commissions.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', TrafficMonthlyCommission::class);
        if (request()->ajax()) {
            $commissions = TrafficMonthlyCommission::viewIndex();
            return $commissions;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', TrafficMonthlyCommission::class);
        $job_files = JobFile::orderBy('created_at', 'DESC')->get();
        return view($this->prefix . 'create', compact('job_files'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', TrafficMonthlyCommission::class);
        TrafficMonthlyCommission::create($this->validateRequest());
        return redirect(route($this->prefix . 'index'))->with('success', __("main.commission_added"));
    }

    public function print()
    {
        if (request('month') && request('year')) {
            $date_str = '01-' . request('month') . '-' . request('year');
            $date = Carbon::createFromFormat('d-m-Y', $date_str);
            $start = clone $date;
            $end = clone $date;
            $start = $start->startOfMonth();
            $end = $end->endOfMonth();
            $commissions = TrafficMonthlyCommission::where('date', '>=', $start)->where('date', '<=', $end)->with('job_file')->get();
            if (!$commissions->count()) {
                return redirect(route($this->prefix . 'index'))->with('error', __("main.no_data_for_selected_date") . $date_str);
            }
            return view($this->prefix . 'print', compact('commissions', 'date'));
        } else {
            return redirect(route($this->prefix . 'index'))->with('error', __("main.missing_month_year_data"));
        }
    }

    public function edit(TrafficMonthlyCommission $trafficMonthlyCommission)
    {
        $this->authorize('update', $trafficMonthlyCommission);
        $job_files = JobFile::orderBy('created_at', 'DESC')->get();
        return view($this->prefix . 'edit', ['commission' => $trafficMonthlyCommission, 'job_files' => $job_files]);
    }

    public function update(Request $request, TrafficMonthlyCommission $trafficMonthlyCommission)
    {
        $this->authorize('update', $trafficMonthlyCommission);
        $trafficMonthlyCommission->update($this->validateRequest());
        return redirect(route($this->prefix . 'index'))->with('success', __("main.commission_updated"));
    }

    public function destroy(TrafficMonthlyCommission $trafficMonthlyCommission)
    {
        $this->authorize('delete', $trafficMonthlyCommission);
        $trafficMonthlyCommission->delete();
        return redirect(route($this->prefix . 'index'))->with('success', __("main.commission_deleted"));
    }


    private function validateRequest()
    {
        $rules = [
            'date' => 'required|date_format:d-m-Y',
            'job_id' => 'required|exists:job_files,id',
            'amount' => 'required|numeric|min:0',
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        request()->request->set('date', '01-' . request('month') . '-' . request('year'));
        return request()->validate($rules);
    }
}
