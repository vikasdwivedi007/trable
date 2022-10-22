<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\JobFile;
use App\Models\TrafficVoucher;
use Illuminate\Http\Request;

class TrafficVoucherController extends Controller
{

    private $prefix = 'traffic-vouchers.';
    private $redirect_prefix = 'vouchers.';
    private $tab_hash = '#pills-Traffic-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', TrafficVoucher::class);
        $vouchers = TrafficVoucher::vouchersIndex();
        return $vouchers;
    }

    public function show(TrafficVoucher $trafficVoucher)
    {
        $this->authorize('view', $trafficVoucher);
        $trafficVoucher->load('job_file');
        $trafficVoucher->formatSerialNo();
        return view($this->prefix . 'show', ['voucher'=>$trafficVoucher]);
    }

    public function create()
    {
        $this->authorize('create', TrafficVoucher::class);
        return view($this->prefix . 'create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', TrafficVoucher::class);
        $data = $this->validateRequest();
        $data['job_id'] = JobFile::where('file_no', $data['file_no'])->first()->id;
        $voucher = TrafficVoucher::create($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.voucher_added"));
    }

    public function edit(TrafficVoucher $trafficVoucher)
    {
        $this->authorize('update', $trafficVoucher);
        $trafficVoucher->load('job_file');
        return view($this->prefix . 'edit', ['voucher' => $trafficVoucher]);
    }

    public function update(Request $request, TrafficVoucher $trafficVoucher)
    {
        $this->authorize('update', $trafficVoucher);
        $data = $this->validateRequest();
        $data['job_id'] = JobFile::where('file_no', $data['file_no'])->first()->id;
        $trafficVoucher->update($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.voucher_updated"));
    }

    public function destroy(TrafficVoucher $trafficVoucher)
    {
        $this->authorize('delete', $trafficVoucher);
        $trafficVoucher->delete();
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.voucher_deleted"));
    }


    private function validateRequest()
    {
        $rules = [
            'file_no' => 'required|exists:job_files,file_no',
            'issued_by' => 'required',
            'to' => 'required',
            'details' => 'nullable',
        ];
        return request()->validate($rules);
    }
}
