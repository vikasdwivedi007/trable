<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\DraftInvoice;
use App\Http\Controllers\Controller;
use App\Models\JobFile;
use App\Models\Lift;
use App\Models\Sightseeing;
use App\Models\SLShow;
use App\Models\VBNight;
use Illuminate\Http\Request;

class DraftInvoiceController extends Controller
{
    private $prefix = 'draft-invoices.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', DraftInvoice::class);
        if (request()->ajax()) {
            $draft_invoices = DraftInvoice::draftInvoicesIndex();
            return $draft_invoices;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', DraftInvoice::class);
        if (!request('job-file') || !JobFile::find(request('job-file'))) {
            return redirect(route('job-files.index'));
        }
        $job_file = JobFile::find(request('job-file'))->load(['travel_agent', 'airport_from', 'airport_to', 'job_visa', 'job_visa.visa', 'job_gifts', 'job_gifts.gift', 'job_router', 'job_router.router', 'accommodations', 'accommodations.room', 'accommodations.room.details', 'accommodations.hotel', 'train_tickets', 'train_tickets.train_ticket', "train_tickets.train_ticket.from_station", 'train_tickets.train_ticket.to_station', 'nile_cruises', 'nile_cruises.nile_cruise', 'nile_cruises.nile_cruise.from_city', 'nile_cruises.nile_cruise.to_city', 'nile_cruises.cabins', 'flights', 'flights.flight', 'flights.flight.airport_from', 'flights.flight.airport_to', 'guides', 'guides.guide', 'guides.sightseeing', 'programs', 'programs.items', 'programs.items.program_itemable',
            'programs' => function ($query) {
                $query->orderBy('day', 'asc');
            }
            , 'programs.city', 'concierge_emp', 'concierge_emp.user']);
        foreach ($job_file->programs as $program) {
            foreach ($program->items as $item) {
                switch ($item->program_itemable_type) {
                    case Sightseeing::class:
                        $name = $item->program_itemable->name;
                        $item->name = $name;
                        break;
                    case VBNight::class:
                        $name = $item->program_itemable->name;
                        $item->name = $name;
                        break;
                    case SLShow::class:
                        $name = "Sound & Light show - " . $item->program_itemable->place;
                        $item->name = $name;
                        break;
                    case Lift::class:
                        $name = "Transportation - " . $item->program_itemable->details;
                        $item->name = $name;
                        break;
                }
            }
        }
        return view($this->prefix . 'create', compact('job_file'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', DraftInvoice::class);
        $data = $this->validateRequest();
        $draftInvoice = DraftInvoice::create($data);
        $draftInvoice->createOrUpdateItems($data);
        if (request()->ajax()) {
            session()->flash('success', __('main.draft_invoice_added'));
            return response()->json(['success' => true, 'message' => __('main.draft_invoice_added'), 'redirect_to' => route($this->prefix . 'index')]);
        } else {
            return redirect(route($this->prefix . 'index'))->with('success', __('main.draft_invoice_added'));
        }
    }

    public function show(DraftInvoice $draftInvoice)
    {
        $this->authorize('viewAny', DraftInvoice::class);
        $draftInvoice->load(['job_file', 'job_file.travel_agent', 'items']);
        return view($this->prefix . 'show_en', compact('draftInvoice'));
    }

    public function edit(DraftInvoice $draftInvoice)
    {
        $this->authorize('update', $draftInvoice);
        $draftInvoice->load(['job_file', 'job_file.travel_agent', 'items']);
        return view($this->prefix . 'edit', compact('draftInvoice'));
    }

    public function update(Request $request, DraftInvoice $draftInvoice)
    {
        $this->authorize('update', $draftInvoice);
        $data = $this->validateRequest();
        $draftInvoice->update($data);
        $draftInvoice->createOrUpdateItems($data);
        if (request()->ajax()) {
            session()->flash('success', __('main.draft_invoice_updated'));
            return response()->json(['success' => true, 'message' => __('main.draft_invoice_updated'), 'redirect_to' => route($this->prefix . 'index')]);
        } else {
            return redirect(route($this->prefix . 'index'))->with('success', __('main.draft_invoice_updated'));
        }
    }

//    public function destroy(DraftInvoice $draftInvoice)
//    {
//        //
//    }


    private function validateRequest()
    {
        $rules = [
            'job_id' => 'required|exists:job_files,id',
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
