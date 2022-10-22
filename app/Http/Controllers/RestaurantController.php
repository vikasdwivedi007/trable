<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RestaurantController extends Controller
{

    private $prefix = 'restaurants.';
    private $redirect_prefix = 'suppliers.';
    private $tab_hash = '#pills-Restaurants-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Restaurant::class);
        if(request()->ajax()){
            $restaurants = Restaurant::restaurantsIndex();
            return $restaurants;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', Restaurant::class);
        $cities = City::getRestaurantCities();
        return view($this->prefix . 'create', compact('cities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Restaurant::class);
        $data = $this->validateRequest();
        $restaurant = Restaurant::create($data);
        $restaurant->createOrUpdateMenus(isset($data['menus']) ? $data['menus'] : []);
        $restaurant->createOrUpdateContacts(isset($data['contacts']) ? $data['contacts'] : []);
        return redirect(route($this->redirect_prefix . 'index').$this->tab_hash)->with('success', __("main.restaurant_added"));
    }

    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        $restaurant->load(['menus', 'contacts']);
        $cities = City::getRestaurantCities();
        return view($this->prefix . 'edit', compact('restaurant', 'cities'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        $data = $this->validateRequest();
        $restaurant->update($data);
        $restaurant->createOrUpdateMenus(isset($data['menus']) ? $data['menus'] : []);
        $restaurant->createOrUpdateContacts(isset($data['contacts']) ? $data['contacts'] : []);
        return redirect(route($this->redirect_prefix . 'index').$this->tab_hash)->with('success', __("main.restaurant_updated"));
    }

    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);
        $restaurant->delete();
        $restaurant->menus()->delete();
        $restaurant->contacts()->delete();
        return redirect(route($this->redirect_prefix . 'index').$this->tab_hash)->with('success', __("main.restaurant_deleted"));
    }




    private function validateRequest()
    {
        $rules = [
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'required|numeric',
            'contacts' => 'nullable|array',
            'contacts.*.name' => 'nullable',
            'contacts.*.email' => 'nullable|email',
            'contacts.*.phone' => 'nullable|numeric',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required',
            'menus' => 'array',
            'menus.*.id' => 'nullable|exists:restaurant_menus,id',
            'menus.*.name' => 'required',
            'menus.*.buy_price' => 'nullable|numeric',
            'menus.*.sell_price_vat_exc' => 'nullable|numeric',
            'menus.*.items' => 'required',
            'menus.*.buy_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'menus.*.sell_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
        ];
        Helpers::formatRestaurantRequestParams();
        return request()->validate($rules);
    }
}
