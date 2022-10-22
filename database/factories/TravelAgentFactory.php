<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TravelAgent;
use Faker\Generator as Faker;

$factory->define(TravelAgent::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->e164PhoneNumber,
        'rate_amount' => 15.2,
        'country_id' => \App\Models\Country::first() ? \App\Models\Country::first()->id : factory(\App\Models\Country::class),
        'city_id' => \App\Models\City::first() ? \App\Models\City::first()->id : factory(\App\Models\City::class),
        'address' => $faker->address
    ];
});
