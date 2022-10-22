<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Sightseeing;
use App\Models\VBNight;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VBNightController extends Controller
{

    private $prefix = 'vbnights.';
    private $redirect_prefix = 'services.';
    private $tab_hash = '#pills-Visit-by-Night-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', VBNight::class);
        $vbnights = VBNight::vbnightsIndex();
        return $vbnights;
    }

    public function sort_by_relation()
    {
        $this->authorize('viewAny', VBNight::class);
        $vbnights = VBNight::sort();
        return view($this->prefix . 'index', compact('vbnights'));
    }

    public function create()
    {
        $this->authorize('create', VBNight::class);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'create', compact('cities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', VBNight::class);
        $data = $this->validateRequest();
        $vbnight = VBNight::create($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.visit_added"));
    }

    public function edit(VBNight $vbnight)
    {
        $this->authorize('update', $vbnight);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'edit', compact('vbnight', 'cities'));
    }

    public function update(Request $request, VBNight $vbnight)
    {
        $this->authorize('update', $vbnight);
        $data = $this->validateRequest();
        $vbnight->update($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.visit_updated"));
    }

    public function destroy(VBNight $vbnight)
    {
        $this->authorize('delete', $vbnight);
        $result = $vbnight->delete();
        if($result){
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.visit_deleted"));
        }else{
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('error', __("main.visit_not_deleted_linked_job_file"));
        }
    }

    public function searchByCity()
    {
        if (request('city_id')) {
            $vbnights = VBNight::where('city_id', request('city_id'))->orderBy('name')->get();
            $vbnights->map(function($vbnight){
                $vbnight->adult_sell_currency = Currency::currencyName($vbnight->adult_sell_currency);
                $vbnight->child_sell_currency = Currency::currencyName($vbnight->child_sell_currency);
            });
            return response()->json(['vbnights'=>$vbnights]);
        }
    }



    private function validateRequest()
    {
        $rules = [
            'name' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'buy_price_adult' => 'nullable|numeric',
            'sell_price_adult_vat_exc' => 'nullable|numeric',
            'buy_price_child' => 'nullable|numeric',
            'sell_price_child_vat_exc' => 'nullable|numeric',
            'adult_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'adult_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'child_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'child_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
