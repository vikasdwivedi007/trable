<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Restaurant;
use App\Models\Sightseeing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SightseeingController extends Controller
{

    private $prefix = 'sightseeings.';
    private $redirect_prefix = 'services.';
    private $tab_hash = '#pills-Sightseeing-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Sightseeing::class);
        $sightseeings = Sightseeing::sightseeingsIndex();
        return $sightseeings;
    }

    public function create()
    {
        $this->authorize('create', Sightseeing::class);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'create', compact('cities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Sightseeing::class);
        $data = $this->validateRequest();
        $sightseeing = Sightseeing::create($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.excursion_added"));
    }

    public function edit(Sightseeing $sightseeing)
    {
        $this->authorize('update', $sightseeing);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'edit', compact('sightseeing', 'cities'));
    }

    public function update(Request $request, Sightseeing $sightseeing)
    {
        $this->authorize('update', $sightseeing);
        $data = $this->validateRequest();
        $sightseeing->update($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.excursion_updated"));
    }

    public function destroy(Sightseeing $sightseeing)
    {
        $this->authorize('delete', $sightseeing);
        $result = $sightseeing->delete();
        if($result){
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.excursion_deleted"));
        }else{
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('error', __("main.excursion_not_deleted_linked_job_file"));
        }
    }

    public function searchSightseeingsByCity()
    {
        if (request('city_id')) {
            $sightseeings = Sightseeing::where('city_id', request('city_id'))->orderBy('name')->get();
            $sightseeings->map(function($sightseeing){
                $sightseeing->sell_price_adult_currency = Currency::currencyName($sightseeing->sell_price_adult_currency);
                $sightseeing->sell_price_child_currency = Currency::currencyName($sightseeing->sell_price_child_currency);
            });
            return response()->json(['sightseeings'=>$sightseeings]);
        }
    }




    private function validateRequest()
    {
        $rules = [
            'name' => 'required|string|min:4',
            'city_id' => 'required|exists:cities,id',
            'desc' => 'nullable',
            'buy_price_adult' => 'nullable|numeric',
            'sell_price_adult_vat_exc' => 'nullable|numeric',
            'buy_price_child' => 'nullable|numeric',
            'sell_price_child_vat_exc' => 'nullable|numeric',
            'buy_price_adult_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'sell_price_adult_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'buy_price_child_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'sell_price_child_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],

        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
