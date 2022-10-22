<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\VBNight;
use App\Models\City;
use App\Models\Country;
use Faker\Generator as Faker;

$factory->define(VBNight::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'city_id' => City::where('country_id', \App\Models\Country::EGYPT_ID)->first() ? City::where('country_id', Country::EGYPT_ID)->inRandomOrder()->first()->id : 1023,
        'currency' => rand(1,3),
        'buy_price_adult' => rand(100, 200),
        'sell_price_adult_vat_exc' => rand(200, 300),
        'buy_price_child' => rand(50, 100),
        'sell_price_child_vat_exc' => rand(100, 150),
    ];
});
