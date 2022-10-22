<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function changeTheme()
    {
        if (in_array(request('theme'), ['theme-light', 'theme-dark'])) {
            $value = request('theme');
            return response()->json(['success' => true])->withCookie(cookie()->forever('theme', $value));
        }
    }

    public function changeLang()
    {
        if (!request()->cookie('lang') || request()->cookie('lang') == 'en') {
            $cookie = cookie()->forever('lang', 'fr');
        } else {
            $cookie = cookie()->forever('lang', 'en');
        }
        return back()->withCookie($cookie);
    }

    public function getCountryCities()
    {
        $data = ['cities' => []];
        if (request('country_id')) {
            $data['cities'] = City::where('country_id', request('country_id'))->get();
        }
        return response()->json($data);
    }
}
