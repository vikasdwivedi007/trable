<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Currency;
use App\Models\Gift;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GiftController extends Controller
{
    private $prefix = 'gifts.';
    private $redirect_prefix = 'services.';
    private $tab_hash = '#pills-Gifts-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Gift::class);
        $gifts = Gift::giftsIndex();
        return $gifts;
    }

    public function create()
    {
        $this->authorize('create', Gift::class);
        return view($this->prefix . 'create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Gift::class);
        $data = $this->validateRequest();
        $gift = Gift::create($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.gift_added'));
    }

    public function edit(Gift $gift)
    {
        $this->authorize('update', $gift);
        return view($this->prefix . 'edit', compact('gift'));
    }

    public function update(Request $request, Gift $gift)
    {
        $this->authorize('update', $gift);
        $data = $this->validateRequest();
        $gift->update($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.gift_updated'));
    }

    public function destroy(Gift $gift)
    {
        $this->authorize('delete', $gift);
        $result = $gift->delete();
        if($result){
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.gift_deleted'));
        }else{
            return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('error', __('main.gift_not_deleted_linked_job_file'));
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
