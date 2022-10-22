<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\File;
use App\Models\Language;
use App\Models\Shop;
use App\Models\SLShow;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private $prefix = 'shops.';
    private $redirect_prefix = 'services.';
    private $tab_hash = '#pills-Shops-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Shop::class);
        $shops = Shop::shopsIndex();
        return $shops;
    }

    public function create()
    {
        $this->authorize('create', Shop::class);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'create', compact('cities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Shop::class);
        $data = $this->validateRequest();
        $shop = Shop::create($data);
        $shop->saveContract(isset($data['contract']) ? $data['contract'] : null);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.shop_added"));
    }

    public function edit(Shop $shop)
    {
        $this->authorize('update', $shop);
        $shop->load('file');
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'edit', compact('shop', 'cities'));
    }

    public function update(Request $request, Shop $shop)
    {
        $this->authorize('update', $shop);
        $data = $this->validateRequest();
        $shop->update($data);
        $shop->saveContract(isset($data['contract']) ? $data['contract'] : null);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.shop_updated"));
    }

    public function destroy(Shop $shop)
    {
        $this->authorize('delete', $shop);
        $result = $shop->delete();
        if($result){
            $shop->file()->delete();
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.shop_deleted"));
        }else{
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.shop_not_deleted_linked_job_file"));
        }
    }


    private function validateRequest()
    {
        $rules = [
            'name' => 'required|string|min:4',
            'phone' => 'required|numeric',
            'city_id' => 'required|exists:cities,id',
            'commission' => 'required|numeric|min:0',
            'address' => 'required',
            'contract' => 'file',
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
