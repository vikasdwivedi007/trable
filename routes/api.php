<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::get('test', function (){
//    dd(\App\Models\CompareHotelPrices::getIDFromURL('https://www.tripadvisor.com/Hotel_Review-g938947-d796249-Reviews-Stella_Di_Mare_Sea_Club_Hotel-Ain_Sukhna_Red_Sea_and_Sinai.html'));
    $id = \App\Models\CompareHotelPrices::getHotelID('four seasons cairo');
    dd([$id, \App\Models\CompareHotelPrices::getHotelPrices($id)]);
//    dd(\App\Models\Currency::convertCurrency('USD', 'EURO', 15));
});*/
