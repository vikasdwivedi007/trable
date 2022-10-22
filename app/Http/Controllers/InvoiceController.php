<?php

namespace App\Http\Controllers;

use App\Models\DraftInvoice;
use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $prefix = 'invoices.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Invoice::class);
        if (request()->ajax()) {
            $invoices = Invoice::invoicesIndex();
            return $invoices;
        }
        return view($this->prefix . 'index');
    }

    public function list()
    {
        $this->authorize('viewAny', Invoice::class);
        $total_count = Invoice::count();
        return view($this->prefix . 'list', compact('total_count'));
    }

    public function create()
    {
        $this->authorize('create', Invoice::class);
        $draftInvoice = null;
        if (request('draft-invoice')) {
            $draftInvoice = DraftInvoice::where('number', request('draft-invoice'))->with(['items', 'job_file', 'job_file.travel_agent'])->first();
        }
        return view($this->prefix . 'create', compact('draftInvoice'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Invoice::class);
        $data = $this->validateRequest();
        $invoice = Invoice::create($data);
        $invoice->createOrUpdateItems($data);
        if (request()->ajax()) {
            session()->flash('success', __('main.invoice_added'));
            return response()->json(['success' => true, 'message' => 'Invoice added successfully', 'redirect_to' => route($this->prefix . 'index')]);
        } else {
            return redirect(route($this->prefix . 'index'))->with('success', __('main.invoice_added'));
        }
    }

    public function show(Invoice $invoice)
    {
        $this->authorize('viewAny', Invoice::class);
        $lang = in_array(request('lang'), ['en', 'fr']) ? request('lang') : 'en';
        $invoice->load(['items', 'draft_invoice', 'draft_invoice.job_file', 'draft_invoice.job_file.travel_agent', 'draft_invoice.job_file.created_by_emp', 'draft_invoice.job_file.created_by_emp.user']);
        return view($this->prefix . 'show_' . $lang, compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $this->authorize('update', $invoice);
        $invoice->load(['items', 'draft_invoice', 'draft_invoice.job_file', 'draft_invoice.job_file.travel_agent']);
        return view($this->prefix . 'edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->authorize('update', $invoice);
        $data = $this->validateRequest();
        $invoice->update($data);
        $invoice->createOrUpdateItems($data);
        if (request()->ajax()) {
            session()->flash('success', __('main.invoice_updated'));
            return response()->json(['success' => true, 'message' => 'Invoice updated successfully', 'redirect_to' => route($this->prefix . 'index')]);
        } else {
            return redirect(route($this->prefix . 'index'))->with('success', __('main.invoice_updated'));
        }
    }

//    public function destroy(Invoice $invoice)
//    {
//        //
//    }


    private function validateRequest()
    {
        $rules = [
            'draft_invoice_id' => 'required|exists:draft_invoices,id',
            'date' => 'required|date_format:d F Y',
            'status' => 'required|in:0,1',
            'currency' => 'required',
            'items' => 'required|array',
            'items.*.details' => 'required',
            'items.*.price' => 'required',
            'items.*.vat' => 'required',
            'items.*.currency.*.name' => 'required',
        ];
        return request()->validate($rules);
    }
}
