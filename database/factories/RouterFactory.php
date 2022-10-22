<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Router;
use Faker\Generator as Faker;

$factory->define(Router::class, function (Faker $faker) {
    return [
        'serial_no' => \Illuminate\Support\Str::random(10),
        'provider' => array_keys(Router::providers())[rand(0,3)],
        'number' => rand(1, 20),
        'quota' => rand(20, 1000),
        'city_id' => \App\Models\City::first() ? \App\Models\City::first()->id : factory(\App\Models\City::class)->create()->id,
        'package_buy_price' => rand(50, 100),
        'package_sell_price_vat_exc' => rand(100, 150),
    ];
});
