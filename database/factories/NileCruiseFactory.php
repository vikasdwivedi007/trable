<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\NileCruise;
use App\Models\City;
use App\Models\Country;
use Faker\Generator as Faker;

$factory->define(NileCruise::class, function (Faker $faker) {
    return [
        'company_name' => $faker->lastName. ' Company',
        'name' => $faker->lastName. ' Cruise',
        'rooms_count' => rand(1, 5),
        'rooms_type' => rand(1,8),
        'adults_count' => rand(1,5),
        'children_count' => rand(1,5),
        'child_free_until' => rand(1,10),
        'date_from' => \Carbon\Carbon::now()->format('l d F Y'),
        'date_to' => \Carbon\Carbon::now()->addDays(4)->format('l d F Y'),
        'from_city_id' => City::where('country_id', \App\Models\Country::EGYPT_ID)->first() ? City::where('country_id', Country::EGYPT_ID)->inRandomOrder()->first()->id : 1023,
        'to_city_id' => City::where('country_id', \App\Models\Country::EGYPT_ID)->first() ? City::where('country_id', Country::EGYPT_ID)->inRandomOrder()->first()->id : 1023,
        'currency'=> rand(1,3),
        'sgl_buy_price' => rand(100, 10000),
        'sgl_sell_price' => rand(100, 10000),
        'dbl_buy_price' => rand(100, 10000),
        'dbl_sell_price' => rand(100, 10000),
        'trpl_buy_price' => rand(100, 10000),
        'trpl_sell_price' => rand(100, 10000),
        'child_buy_price' => rand(100, 10000),
        'child_sell_price' => rand(100, 10000),
        'sight_buy_price' => rand(100, 10000),
        'sight_sell_price' => rand(100, 10000),
        'private_guide_buy_price' => rand(100, 10000),
        'private_guide_sell_price' => rand(100, 10000),
        'boat_guide_buy_price' => rand(100, 10000),
        'boat_guide_sell_price' => rand(100, 10000),

    ];
});
