<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Guide;
use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuideController extends Controller
{

    private $prefix = 'guides.';
    private $redirect_prefix = 'suppliers.';
    private $tab_hash = '#pills-Guides-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Guide::class);
        if (request()->ajax()) {
            $guides = Guide::guidesIndex();
            return $guides;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', Guide::class);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        $languages = Language::all();
        return view($this->prefix . 'create', compact('cities', 'languages'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Guide::class);
        $data = $this->validateRequest();
        $guide = Guide::create($data);
        $guide->updateLanguages($data);
        $guide->saveAdditionalValueCert(isset($data['additional_value_cert']) ? $data['additional_value_cert'] : null);
        $guide->saveTaxID(isset($data['tax_id']) ? $data['tax_id'] : null);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.guide_added'));
    }

    public function edit(Guide $guide)
    {
        $this->authorize('update', $guide);
        $guide->load(['city', 'languages']);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        $languages = Language::all();
        return view($this->prefix . 'edit', compact('guide', 'cities', 'languages'));
    }

    public function update(Request $request, Guide $guide)
    {
        $this->authorize('update', $guide);
        $data = $this->validateRequest();
        $guide->update($data);
        $guide->updateLanguages($data);
        $guide->saveAdditionalValueCert(isset($data['additional_value_cert']) ? $data['additional_value_cert'] : null);
        $guide->saveTaxID(isset($data['tax_id']) ? $data['tax_id'] : null);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.guide_updated'));
    }

    public function destroy(Guide $guide)
    {
        $this->authorize('delete', $guide);
        $result = $guide->delete();
        if ($result) {
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.guide_deleted'));
        } else {
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('error', __('main.guide_not_deleted_linked_job_file'));
        }
    }

    public function getAvailableGuides()
    {
        $data = ['guides' => []];
        if (request('day')) {
            $day = Carbon::createFromFormat('l d F Y', request('day'))->startOfDay();
            $guides = Guide::availableGuides($day, request('job_id'));
            $guides->map->languagesToStr();
            $data['guides'] = $guides;
        }
        return response()->json($data);
    }


    private function validateRequest()
    {
        $rules = [
            'name' => 'required',
            'name_ar' => 'required',
            'phone' => 'required|numeric',
            'license_no' => 'required',
            'city_id' => 'required|exists:cities,id',
            'daily_fee' => 'nullable|numeric|min:0',
            'currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'languages' => 'required|array',
            'languages.*' => 'required|exists:languages,id',
            'additional_value_cert' => 'nullable|file',
            'tax_id' => 'nullable|file',
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
