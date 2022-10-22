<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Airport;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Router;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RouterController extends Controller
{

    private $prefix = 'routers.';
    private $redirect_prefix = 'services.';
    private $tab_hash = '#pills-Routers-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Router::class);
        $routers = Router::routersIndex();
        return $routers;
    }

    public function create()
    {
        $this->authorize('create', Router::class);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'create', compact('cities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Router::class);
        $data = $this->validateRequest();
        $router = Router::create($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.router_added"));
    }

    public function edit(Router $router)
    {
        $this->authorize('update', $router);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'edit', compact('router', 'cities'));
    }

    public function update(Request $request, Router $router)
    {
        $this->authorize('update', $router);
        $data = $this->validateRequest($router);
        $router->update($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.router_updated"));
    }

    public function destroy(Router $router)
    {
        $this->authorize('delete', $router);
        $result = $router->delete();
        if($result){
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.router_deleted"));
        }else{
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('error', __("main.router_not_deleted_linked_job_file"));
        }
    }

    public function getAvailableRouters()
    {
        $data = ['routers' => []];
        if (request('from') && request('to') ) {
            $from = Carbon::createFromFormat('l d F Y', request('from'))->startOfDay();
            $to = Carbon::createFromFormat('l d F Y', request('to'))->endOfDay();
            $data['routers'] = Router::availableRouters($from, $to, request('job_id'));
        }
        return response()->json($data);
    }


    private function validateRequest($router = null)
    {
        $rules = [
            'serial_no' => 'required|string|unique:routers,serial_no',
            'provider' => ['required', 'numeric', Rule::in(array_keys(Router::providers()))],
            'number' => 'required|numeric|min:0',
            'quota' => 'required|numeric|min:0',
            'city_id' => 'required|exists:cities,id',
            'package_buy_price' => 'nullable|numeric',
            'package_sell_price_vat_exc' => 'nullable|numeric',
            'package_buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'package_sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
        ];
        if ($router) {
            $rules['serial_no'] .= ',' . $router->id;
        }
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
