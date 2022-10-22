<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LKFriend;
use Faker\Generator as Faker;

$factory->define(LKFriend::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->e164PhoneNumber,
        'city_id' => \App\Models\City::first() ? \App\Models\City::first()->id : factory(\App\Models\City::class)->create()->id,
        'rent_day' => rand(100, 200),
//        'base_rent_day' => rand(50, 100),
        'sell_rent_day_vat_exc' => rand(150, 250)
    ];
});
