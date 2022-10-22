<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\NileCruise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NileCruiseController extends Controller
{
    private $prefix = 'nile-cruises.';
    private $redirect_prefix = 'suppliers.';
    private $tab_hash = '#pills-Nile-Cruises-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', NileCruise::class);
        if (request()->ajax()) {
            $nile_cruises = NileCruise::nileCruisesIndex();
            return $nile_cruises;
        }
        return view($this->prefix . 'index');
    }

    public function sort_by_relation()
    {
        $this->authorize('viewAny', NileCruise::class);
        $nile_cruises = NileCruise::sort();
        return view($this->prefix . 'index', compact('nile_cruises'));
    }

    public function create()
    {
        $this->authorize('create', NileCruise::class);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'create', compact('cities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', NileCruise::class);
        $data = $this->validateRequest();
        NileCruise::create($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.nile_cruise_added'));
    }

    public function edit(NileCruise $nile_cruise)
    {
        $this->authorize('update', $nile_cruise);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'edit', compact('nile_cruise', 'cities'));
    }

    public function update(Request $request, NileCruise $nile_cruise)
    {
        $this->authorize('update', $nile_cruise);
        $data = $this->validateRequest();
        $nile_cruise->update($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.nile_cruise_updated'));
    }

    public function destroy(NileCruise $nile_cruise)
    {
        $this->authorize('delete', $nile_cruise);
        $result = $nile_cruise->delete();
        if ($result) {
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.nile_cruise_deleted'));
        } else {
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('error', __('main.nile_cruise_not_deleted_linked_job_file'));
        }
    }

    public function getCruiseNamesByDateAndCity()
    {
        $data = ['cruises' => []];
        if (request('city_id') && request('arrival_date') && request('departure_date')) {
            $arrival_date = Carbon::createFromFormat('l d F Y', request('arrival_date'))->format('Y-m-d');
            $departure_date = Carbon::createFromFormat('l d F Y', request('departure_date'))->format('Y-m-d');
            $cruises = NileCruise::where('date_from', '>=', $arrival_date)->where('date_from', '<=', $departure_date)
                ->where('from_city_id', request('city_id'))
                ->orderBy('name')->get();
            foreach ($cruises as $cruise) {
                if (!in_array($cruise->name, $data['cruises'])) {
                    $data['cruises'][] = $cruise->name;
                }
            }
        }
        return response()->json($data);
    }

    public function getCruiseByNameDateAndCity()
    {
        $data = ['cruises' => [], 'dates' => []];
        $dates = [];
        if (request('city_id') && request('name') && request('arrival_date') && request('departure_date')) {
            $arrival_date = Carbon::createFromFormat('l d F Y', request('arrival_date'))->format('Y-m-d');
            $departure_date = Carbon::createFromFormat('l d F Y', request('departure_date'))->format('Y-m-d');
            $cruises = NileCruise::where('date_from', '>=', $arrival_date)->where('date_from', '<=', $departure_date)
                ->where('name', request('name'))
                ->where('from_city_id', request('city_id'))
                ->with('from_city', 'to_city')->get();

            foreach ($cruises as $cruise) {
                $cruise = $cruise->toArray();
                $cruise['sgl_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['sgl_buy_price']]);
                $cruise['dbl_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['dbl_sell_price']]);
                $cruise['trpl_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['trpl_sell_price']]);
                $cruise['child_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['child_sell_price']]);
                $cruise['private_guide_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['private_guide_sell_price']]);
                $cruise['boat_guide_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['boat_guide_sell_price']]);
                $cruise['dates'] = $cruise['date_from'] . ' - ' . $cruise['date_to'];
                if (!isset($dates[$cruise['dates']])) {
                    $dates[$cruise['dates']] = [];
                }
                foreach ($cruise as $key => $value) {
                    if (!$value) {
                        $cruise[$key] = 0;
                    }
                }
                $data['cruises'][] = $cruise;
                $dates[$cruise['dates']][] = $cruise['id'];
            }
        }
        foreach ($dates as $date => $date_cruises) {
            $data['dates'][] = ['date' => $date, 'cruise_ids' => join(',', $date_cruises)];
        }
        return response()->json($data);
    }

    public function getCruisesByIDs()
    {
        $data = ['cruises' => [], 'cabin_type' => [], 'deck_type' => [], 'including_sightseeing' => [], 'room_type' => []];
        if (request('cruise_ids')) {
            $ids = explode(',', request('cruise_ids'));
            foreach ($ids as $id) {
                $cruise = NileCruise::find(trim($id));
                if ($cruise) {
                    $cruise->load('from_city', 'to_city');
                    if (request('cabin_type') && $cruise->cabin_type != request('cabin_type')) {
                        continue;
                    }
                    if (request('deck_type') && $cruise->deck_type != request('deck_type')) {
                        continue;
                    }
                    if (request('including_sightseeing') !== null && $cruise->including_sightseeing != request('including_sightseeing')) {
                        continue;
                    }
                    $room_types = $cruise->getAvailableRoomTypes();
                    if (request('room_type') && !in_array(request('room_type'), array_keys($room_types))) {
                        continue;
                    }
                    $cruise = $cruise->toArray();
                    $cruise['sgl_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['sgl_buy_price']]);
                    $cruise['dbl_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['dbl_sell_price']]);
                    $cruise['trpl_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['trpl_sell_price']]);
                    $cruise['child_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['child_sell_price']]);
                    $cruise['private_guide_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['private_guide_sell_price']]);
                    $cruise['boat_guide_sell_currency'] = Currency::currencyName($cruise[NileCruise::pricesFieldsWithCurrencies()['boat_guide_sell_price']]);
                    $cruise['dates'] = $cruise['date_from'] . ' - ' . $cruise['date_to'];
                    foreach ($cruise as $key => $value) {
                        if (!$value) {
                            $cruise[$key] = 0;
                        }
                    }
                    if (!isset($data['cabin_type'][$cruise['cabin_type']])) {
                        $data['cabin_type'][] = $cruise['cabin_type'];
                    }
                    if (!isset($data['deck_type'][$cruise['deck_type']])) {
                        $data['deck_type'][] = $cruise['deck_type'];
                    }
                    if (!isset($data['including_sightseeing'][$cruise['including_sightseeing']])) {
                        $data['including_sightseeing'][] = ['key' => $cruise['including_sightseeing'], 'value' => $cruise['including_sightseeing'] ? 'Yes' : "No"];
                    }
                    foreach ($room_types as $key => $type) {
                        $data['room_type'][$key] = $type;
                    }
                    $data['cruises'][] = $cruise;
                }
            }
        }
        $room_types = $data['room_type'];
        ksort($room_types);
        $room_types_final = [];
        foreach ($room_types as $key => $value) {
            $room_types_final[] = ['key' => $key, 'value' => $value];
        }
        $data['room_type'] = $room_types_final;

        return response()->json($data);
    }


    private function validateRequest()
    {
        $rules = [
            'company_name' => 'required',
            'name' => 'required',
//            'rooms_count' => 'required|numeric|min:1',
//            'rooms_type' => ['required', Rule::in([1, 2, 3, 4, 5, 6, 7, 8])],
//            'adults_count' => 'required|numeric|min:0',
//            'children_count' => 'required|numeric|min:0',
//            'child_free_until' => 'nullable|numeric|min:0',
            'date_from' => 'required|date_format:l d F Y',//Friday 15 November 20
            'date_to' => 'required|date_format:l d F Y|after_or_equal:date_from',
            'from_city_id' => 'required|exists:cities,id',
            'to_city_id' => 'required|exists:cities,id',

            'cabin_type' => ['required', Rule::in(['cabin', 'suite'])],
            'deck_type' => ['required', Rule::in(['main', 'upper'])],
            'including_sightseeing' => ['required', Rule::in([0, 1])],

            'sgl_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'sgl_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'dbl_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'dbl_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'trpl_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'trpl_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'child_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'child_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'private_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'private_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'boat_guide_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'boat_guide_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],

            'sgl_buy_price' => 'nullable|numeric|min:0',
            'sgl_sell_price' => 'nullable|numeric|min:0',
            'dbl_buy_price' => 'nullable|numeric|min:0',
            'dbl_sell_price' => 'nullable|numeric|min:0',
            'trpl_buy_price' => 'nullable|numeric|min:0',
            'trpl_sell_price' => 'nullable|numeric|min:0',
            'child_buy_price' => 'nullable|numeric|min:0',
            'child_sell_price' => 'nullable|numeric|min:0',
            'private_guide_salary' => 'nullable|numeric|min:0',
            'private_guide_accommodation' => 'nullable|numeric|min:0',
            'private_guide_buy_price' => 'nullable|numeric|min:0',
            'private_guide_sell_price' => 'nullable|numeric|min:0',
            'boat_guide_buy_price' => 'nullable|numeric|min:0',
            'boat_guide_sell_price' => 'nullable|numeric|min:0',
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
