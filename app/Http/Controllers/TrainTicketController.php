<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\SLShow;
use App\Models\TrainStation;
use App\Models\TrainTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TrainTicketController extends Controller
{
    private $prefix = 'train-tickets.';
    private $redirect_prefix = 'suppliers.';
    private $tab_hash = '#pills-Train-Tickets-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', TrainTicket::class);
        if (request()->ajax()) {
            $train_tickets = TrainTicket::trainTicketsIndex();
            return $train_tickets;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', TrainTicket::class);
        $stations = TrainStation::all();
        return view($this->prefix . 'create', compact('stations'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', TrainTicket::class);
        $data = $this->validateRequest();
        $data = TrainTicket::combineDates($data);
        TrainTicket::create($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.train_ticket_added"));
    }

    public function edit(TrainTicket $train_ticket)
    {
        $this->authorize('update', $train_ticket);
        $stations = TrainStation::all();
        return view($this->prefix . 'edit', compact('train_ticket', 'stations'));
    }

    public function update(Request $request, TrainTicket $train_ticket)
    {
        $this->authorize('update', $train_ticket);
        $data = $this->validateRequest();
        $data = TrainTicket::combineDates($data);
        $train_ticket->update($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.train_ticket_updated"));
    }

    public function destroy(TrainTicket $train_ticket)
    {
        $this->authorize('delete', $train_ticket);
        $result = $train_ticket->delete();
        if ($result) {
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.train_ticket_deleted"));
        } else {
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('error', __("main.train_ticket_not_deleted_linked_job_file"));
        }
    }

    public function searchTrains()
    {
        $data = ['train_ticket' => null];
        if (request('number') && request('date')) {
            $date_start = Carbon::createFromFormat('l d F Y', request('date'))->startOfDay();
            $date_end = Carbon::createFromFormat('l d F Y', request('date'))->endOfDay();
            $train = TrainTicket::where('number', request('number'))
                ->where('depart_at', '>=', $date_start)
                ->where('depart_at', '<=', $date_end)
                ->with(["from_station", 'to_station'])->first();
            if ($train) {
                $train = $train->formatObject();
                $data['train_ticket'] = $train;
            }
        }
        return response()->json($data);
    }

    private function validateRequest()
    {
        $rules = [
            'type' => ['required', Rule::in([1, 2])],//1->seating, 2->sleeping
            'number' => 'nullable|numeric',
            'wagon_no' => 'nullable|numeric',
            'seat_no' => 'nullable|numeric',
            'cabin_no' => 'nullable|numeric',
            'class' => [Rule::in([0, 1, 2])],
            'sgl_buy_price' => 'nullable|numeric',
            'sgl_sell_price' => 'nullable|numeric',
            'dbl_buy_price' => 'nullable|numeric',
            'dbl_sell_price' => 'nullable|numeric',
            'from_station_id' => 'required|exists:train_stations,id',
            'to_station_id' => 'required|exists:train_stations,id',
            'depart_date' => 'required|date|date_format:l d F Y',
            'depart_time' => 'required|date_format:H:i',
            'arrive_date' => 'required|date|date_format:l d F Y',
            'arrive_time' => 'required|date_format:H:i',
            'sgl_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'sgl_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'dbl_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'dbl_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
