<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\LKFriend;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LKFriendController extends Controller
{

    private $prefix = 'lkfriends.';
    private $redirect_prefix = 'services.';
    private $tab_hash = '#pills-Like-Friend-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', LKFriend::class);
        $lkfriends = LKFriend::lkfriendsIndex();
        return $lkfriends;
    }

    public function create()
    {
        $this->authorize('create', LKFriend::class);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        $languages = Language::all();
        return view($this->prefix . 'create', compact('cities', 'languages'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', LKFriend::class);
        $data = $this->validateRequest();
        $lkfriend = LKFriend::create($data);
        $lkfriend->updateLanguages($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.lkfriend_added'));
    }

    public function edit(LKFriend $lkfriend)
    {
        $this->authorize('update', $lkfriend);
        $lkfriend->load('languages');
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        $languages = Language::all();
        return view($this->prefix . 'edit', compact('lkfriend', 'cities', 'languages'));
    }

    public function update(Request $request, LKFriend $lkfriend)
    {
        $this->authorize('update', $lkfriend);
        $data = $this->validateRequest();
        $lkfriend->update($data);
        $lkfriend->updateLanguages($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.lkfriend_updated'));
    }

    public function destroy(LKFriend $lkfriend)
    {
        $this->authorize('delete', $lkfriend);
        $result = $lkfriend->delete();
        if($result){
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.lkfriend_deleted'));
        }else{
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('error', __('main.lkfriend_not_deleted_linked_job_file'));
        }
    }


    private function validateRequest()
    {
        $rules = [
            'name' => 'required|string|min:4',
            'phone' => 'required|numeric',
            'city_id' => 'required|exists:cities,id',
            'languages' => 'required|array',
            'languages.*' => 'required|exists:languages,id',
            'rent_day' => 'nullable|numeric',
            'rent_day_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'sell_rent_day_vat_exc' => 'nullable|numeric',
            'sell_rent_day_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules);
    }
}
