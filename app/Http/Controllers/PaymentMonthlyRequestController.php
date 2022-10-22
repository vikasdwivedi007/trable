<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\PaymentMonthlyRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentMonthlyRequestController extends Controller
{
    private $prefix = 'payment-monthly-requests.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', PaymentMonthlyRequest::class);
        if (request()->ajax()) {
            $payment_requests = PaymentMonthlyRequest::viewIndex();
            return $payment_requests;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', PaymentMonthlyRequest::class);
        return view($this->prefix . 'create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', PaymentMonthlyRequest::class);
        PaymentMonthlyRequest::create($this->validateRequest());
        return redirect(route($this->prefix . 'index'))->with('success', __("main.payment_request_added"));
    }

    public function show(PaymentMonthlyRequest $paymentMonthlyRequest)
    {
        $this->authorize('viewAny', PaymentMonthlyRequest::class);
        return view($this->prefix . 'show', ['payment_request' => $paymentMonthlyRequest]);
    }

    public function edit(PaymentMonthlyRequest $paymentMonthlyRequest)
    {
        $this->authorize('update', $paymentMonthlyRequest);
        return view($this->prefix . 'edit', ['payment_request' => $paymentMonthlyRequest]);
    }

    public function update(Request $request, PaymentMonthlyRequest $paymentMonthlyRequest)
    {
        $this->authorize('update', $paymentMonthlyRequest);
        $paymentMonthlyRequest->update($this->validateRequest());
        return redirect(route($this->prefix . 'index'))->with('success', __("main.payment_request_updated"));
    }

    public function destroy(PaymentMonthlyRequest $paymentMonthlyRequest)
    {
        $this->authorize('delete', $paymentMonthlyRequest);
        $paymentMonthlyRequest->delete();
        return redirect(route($this->prefix . 'index'))->with('success', __("main.payment_request_deleted"));
    }


    private function validateRequest()
    {
        $rules = [
            'date' => 'required|date_format:d-m-Y',
            'request_date' => 'required|date_format:l d F Y',
            'files_count' => 'required|min:0',
            'amount' => 'required|numeric|min:0',
            'words' => 'required',
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        request()->request->set('date', '01-' . request('month') . '-' . request('year'));
        return request()->validate($rules);
    }
}
