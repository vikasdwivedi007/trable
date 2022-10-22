<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Http\Controllers\Controller;
use App\Models\TrafficMonthlyCommission;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    private $prefix = 'commissions.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Commission::class);
//        if (request()->ajax()) {
//            $commissions = Commission::viewIndex();
//            return $commissions;
//        }
        if (request('date')) {
            list($commissions, $operators, $date) = $this->getData(request('date'));
        } else {
            list($commissions, $operators, $date) = $this->getData(Carbon::now()->format('m-Y'));
        }
        return view($this->prefix . 'index', compact('commissions', 'operators', 'date'));
    }

    private function getData($date)
    {
        $date = Carbon::createFromFormat('d-m-Y', '01-' . $date);
        $d1 = clone $date;
        $d2 = clone $date;
        $monthly_commissions = TrafficMonthlyCommission::where('date', '>=', $d1->startOfMonth())->where('date', '<=', $d2->endOfMonth())->with('job_file')->get();
        $operators = [];
        $commissions = [];
        $z = 0;
        foreach ($monthly_commissions as $comm) {
            $op = $comm->job_file->operator()->load('user');
            if (!isset($operators[$op->id])) {
                $op_data = $op->toArray();
                $op_data['total'] = 0;
                $op_data['index'] = $z;
                $operators[$op->id] = $op_data;
                $z++;
            }
            $operators[$op->id]['indexes'][] = $comm->job_file->file_no . '---' . $operators[$op->id]['index'];
            $operators[$op->id]['total'] += $comm->amount;
            $commission_data = $comm->toArray();
            $commission_data['op'] = $operators[$op->id];
            $commissions[] = $commission_data;
        }
        $operators_final = [];
        foreach ($operators as $op) {
            $operators_final[] = $op;
        }
        return [$commissions, $operators_final, $date];
    }
}


