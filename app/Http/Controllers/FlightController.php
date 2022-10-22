<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Airport;
use App\Models\City;
use App\Models\Currency;
use App\Models\Flight;
use App\Models\Router;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FlightController extends Controller
{
    private $prefix = 'flights.';
    private $redirect_prefix = 'suppliers.';
    private $tab_hash = '#pills-Flights-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Flight::class);
        if (request()->ajax()) {
            $flights = Flight::flightsIndex();
            return $flights;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', Flight::class);
        return view($this->prefix . 'create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Flight::class);
        $data = $this->validateRequest();
        $flight = Flight::create($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.flight_added'));
    }

    public function edit(Flight $flight)
    {
        $this->authorize('update', $flight);
        $flight->load(['airport_from', 'airport_to']);
        return view($this->prefix . 'edit', compact('flight'));
    }

    public function update(Request $request, Flight $flight)
    {
        $this->authorize('update', $flight);
        $data = $this->validateRequest();
        $flight->update($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.flight_updated'));
    }

    public function destroy(Flight $flight)
    {
        $this->authorize('delete', $flight);
        $result = $flight->delete();
        if ($result) {
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.flight_deleted'));
        } else {
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('error', __('main.flight_not_deleted_linked_job_file'));
        }
    }

    public function searchFlights()
    {
        $data = ['flight'];
        if (request('flight_no') && request('departure_date') && request('arrival_date')) {
            $flight = Flight::where('number', request('flight_no'))
                ->where('depart_at', '<=', Carbon::createFromFormat('l d F Y', request('departure_date')))
                ->where('arrive_at', '>=', Carbon::createFromFormat('l d F Y', request('arrival_date')))
                ->with(["airport_from", 'airport_to'])->first();
            if ($flight) {
                $flight->status = Flight::availableStatus()[$flight->status];
                $flight->airport_from_formatted = $flight->airport_from->format();
                $flight->airport_to_formatted = $flight->airport_to->format();
            }
            $data['flight'] = $flight;
        }
        return response()->json($data);
    }

    private function validateRequest()
    {
        $rules = [
            'number' => 'required',
            'date' => 'required|date|date_format:l d F Y',
            'from' => 'required|exists:airports,id',
            'to' => 'required|exists:airports,id|different:from',
            'depart_at' => 'required|date_format:H:i',
            'arrive_at' => 'required|date_format:H:i',
            'reference' => 'nullable',
            'seats_count' => 'nullable|numeric|min:1',
            'status' => ['required', Rule::in(array_keys(Flight::availableStatus()))],
            'buy_price' => 'nullable|numeric|min:0',
            'sell_price_vat_exc' => 'nullable|numeric|min:0',
            'buy_price_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'sell_price_vat_exc_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
