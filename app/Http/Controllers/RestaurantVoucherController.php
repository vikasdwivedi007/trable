<?php

namespace App\Http\Controllers;

use App\Models\JobFile;
use App\Models\RestaurantVoucher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RestaurantVoucherController extends Controller
{
    private $prefix = 'restaurant-vouchers.';
    private $redirect_prefix = 'vouchers.';
    private $tab_hash = '#pills-Restaurant-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', RestaurantVoucher::class);
        $vouchers = RestaurantVoucher::vouchersIndex();
        return $vouchers;
    }

    public function show(RestaurantVoucher $restaurantVoucher)
    {
        $this->authorize('view', $restaurantVoucher);
        $restaurantVoucher->load('job_file');
        $restaurantVoucher->formatSerialNo();
        return view($this->prefix . 'show', ['voucher'=>$restaurantVoucher]);
    }

    public function create()
    {
        $this->authorize('create', RestaurantVoucher::class);
        return view($this->prefix . 'create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', RestaurantVoucher::class);
        $data = $this->validateRequest();
        $data['job_id'] = JobFile::where('file_no', $data['file_no'])->first()->id;
        $voucher = RestaurantVoucher::create($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.restaurant_voucher_added"));
    }

    public function edit(RestaurantVoucher $restaurantVoucher)
    {
        $this->authorize('update', $restaurantVoucher);
        $restaurantVoucher->load('job_file');
        return view($this->prefix . 'edit', ['voucher' => $restaurantVoucher]);
    }

    public function update(Request $request, RestaurantVoucher $restaurantVoucher)
    {
        $this->authorize('update', $restaurantVoucher);
        $data = $this->validateRequest();
        $data['job_id'] = JobFile::where('file_no', $data['file_no'])->first()->id;
        $restaurantVoucher->update($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.restaurant_voucher_updated"));
    }

    public function destroy(RestaurantVoucher $restaurantVoucher)
    {
        $this->authorize('delete', $restaurantVoucher);
        $restaurantVoucher->delete();
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.restaurant_voucher_deleted"));
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
