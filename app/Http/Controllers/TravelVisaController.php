<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Currency;
use App\Models\TravelVisa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TravelVisaController extends Controller
{
    private $prefix = 'travel-visas.';
    private $redirect_prefix = 'services.';
    private $tab_hash = '#pills-Travel-visa-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', TravelVisa::class);
        $visas = TravelVisa::travelVisasIndex();
        return $visas;
    }

    public function create()
    {
        $this->authorize('create', TravelVisa::class);
        return view($this->prefix . 'create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', TravelVisa::class);
        $data = $this->validateRequest();
        $visa = TravelVisa::create($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.travel_visa_added"));
    }

    public function edit(TravelVisa $travelVisa)
    {
        $this->authorize('update', $travelVisa);
        return view($this->prefix . 'edit', compact('travelVisa'));
    }

    public function update(Request $request, TravelVisa $travelVisa)
    {
        $this->authorize('update', $travelVisa);
        $data = $this->validateRequest();
        $travelVisa->update($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.travel_visa_updated"));
    }

    public function destroy(TravelVisa $travelVisa)
    {
        $this->authorize('delete', $travelVisa);
        $result = $travelVisa->delete();
        if($result){
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.travel_visa_deleted"));
        }else{
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('error', __("main.travel_visa_not_deleted_linked_job_file"));
        }
    }



    private function validateRequest()
    {
        $rules = [
            'name' => 'required|string|min:4',
            'buy_price' => 'nullable|numeric|min:0',
            'sell_price' => 'nullable|numeric|min:0',
            'buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
