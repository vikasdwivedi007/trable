<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Car;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Transportation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransportationController extends Controller
{

    private $prefix = 'transportations.';
    private $redirect_prefix = 'suppliers.';
    private $tab_hash = '#pills-Transportations-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Transportation::class);
        if (request()->ajax()) {
            $transportations = Transportation::transportationsIndex();
            return $transportations;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', Transportation::class);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'create', compact('cities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Transportation::class);
        $data = $this->validateRequest();
        $transportation = Transportation::create($data);
        $transportation->saveCompanyRegister(isset($data['company_register']) ? $data['company_register'] : null);
        $transportation->saveTaxID(isset($data['tax_id']) ? $data['tax_id'] : null);
        $transportation->createOrUpdateCars(isset($data['cars']) ? $data['cars'] : []);
        $transportation->createOrUpdateContacts(isset($data['contacts']) ? $data['contacts'] : []);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.transportation_added"));
    }

    public function edit(Transportation $transportation)
    {
        $this->authorize('update', $transportation);
        $transportation->load(['cars', 'contacts']);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'edit', compact('transportation', 'cities'));
    }

    public function update(Request $request, Transportation $transportation)
    {
        $this->authorize('update', $transportation);
        $data = $this->validateRequest();
        $transportation->update($data);
        $transportation->saveCompanyRegister(isset($data['company_register']) ? $data['company_register'] : null);
        $transportation->saveTaxID(isset($data['tax_id']) ? $data['tax_id'] : null);
        $transportation->createOrUpdateCars(isset($data['cars']) ? $data['cars'] : []);
        $transportation->createOrUpdateContacts(isset($data['contacts']) ? $data['contacts'] : []);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.transportation_updated"));
    }

    public function destroy(Transportation $transportation)
    {
        $this->authorize('delete', $transportation);
        $transportation->delete();
        $transportation->cars()->delete();
        $transportation->contacts()->delete();
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.transportation_deleted"));
    }

    public function searchCarsByCompany()
    {
        $data = [];
        if(request('transportation_id')){
            $data['cars'] = Car::where('transportation_id', request('transportation_id'))->get();
        }
        return response()->json($data);
    }


    private function validateRequest()
    {
        $rules = [
            'code' => 'nullable',
            'company_register' => 'nullable|file',
            'tax_id' => 'nullable|file',
            'name' => 'required',
            'name_ar' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'contacts' => 'nullable|array',
            'contacts.*.name' => 'nullable',
            'contacts.*.email' => 'nullable|email',
            'contacts.*.phone' => 'nullable|numeric',
            'city_id' => 'required|exists:cities,id',
            'cars' => 'array',
            'cars.*.id' => 'nullable|exists:cars,id',
            'cars.*.driver_name' => 'required',
            'cars.*.driver_name_ar' => 'required',
            'cars.*.driver_phone' => 'required|numeric',
            'cars.*.driver_no' => 'required|numeric',
            'cars.*.car_type' => 'required',
            'cars.*.car_model' => 'required',
            'cars.*.car_no' => 'required',
            'cars.*.buy_price' => 'nullable|numeric',
            'cars.*.sell_price_vat_exc' => 'nullable|numeric',
            'cars.*.buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'cars.*.sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
        ];
        Helpers::formatTransportationRequestParams();
        return request()->validate($rules);
    }
}
