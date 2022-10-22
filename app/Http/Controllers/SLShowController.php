<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Sightseeing;
use App\Models\SLShow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SLShowController extends Controller
{
    private $prefix = 'slshows.';
    private $redirect_prefix = 'services.';
    private $tab_hash = '#pills-Sound-Light-Show-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', SLShow::class);
        $slshows = SLShow::slshowsIndex();
        return $slshows;
    }

    public function create()
    {
        $this->authorize('create', SLShow::class);
        $languages = Language::all();
        return view($this->prefix . 'create', compact('languages'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', SLShow::class);
        $data = $this->validateRequest();
        SLShow::create($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.slshow_added"));
    }

    public function edit(SLShow $slshow)
    {
        $this->authorize('update', $slshow);
        $languages = Language::all();
        return view($this->prefix . 'edit', compact('slshow', 'languages'));
    }

    public function update(Request $request, SLShow $slshow)
    {
        $this->authorize('update', $slshow);
        $data = $this->validateRequest();
        $slshow->update($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.slshow_updated"));
    }

    public function destroy(SLShow $slshow)
    {
        $this->authorize('delete', $slshow);
        $result = $slshow->delete();
        if ($result) {
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.slshow_deleted"));
        } else {
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('error', __("main.slshow_not_deleted_linked_job_file"));
        }
    }

    public function getLangsByCityAndDate()
    {
        $data = ['langs' => []];
        if (request('date') && request('place')) {
            $date = Carbon::createFromFormat('l d F Y', request('date'))->format('Y-m-d');
            $data = SLShow::getLangsByCityAndDate($date, request('place'));
        }
        return response()->json($data);
    }

    public function getTimesByLangPlaceAndDate()
    {
        $data = ['slshows' => []];
        if (request('date') && request('place') && request('language_id')) {
            $date = Carbon::createFromFormat('l d F Y', request('date'))->format('Y-m-d');
            $slshows = SLShow::where('date', $date)->where('place', request('place'))->where('language_id', request('language_id'))->get();
            $slshows->map(function ($slshow) {
                $slshow->adult_sell_currency = Currency::currencyName($slshow->adult_sell_currency);
                $slshow->child_sell_currency = Currency::currencyName($slshow->child_sell_currency);
            });
            $data['slshows'] = $slshows->toArray();
        }
        return response()->json($data);
    }


    private function validateRequest()
    {
        $rules = [
            'date' => 'required|date|date_format:l d F Y',
            'place' => 'required',
            'language_id' => 'required|exists:languages,id',
            'time' => 'required|date_format:H:i',
            'buy_price_adult' => 'nullable|numeric',
            'sell_price_adult_vat_exc' => 'nullable|numeric',
            'buy_price_child' => 'nullable|numeric',
            'sell_price_child_vat_exc' => 'nullable|numeric',
            'ticket_type' => 'required',
            'adult_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'adult_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'child_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'child_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
        ];
        if (request('language_id') && request('language_id') == Language::ALL_LANGUAGES_ID) {
            $rules['language_id'] = 'required';
        }
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
