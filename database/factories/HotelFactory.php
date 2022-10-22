<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Hotel;
use App\Models\City;
use App\Models\Country;
use Faker\Generator as Faker;

$factory->define(Hotel::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'phone' => $faker->e164PhoneNumber,
        'email' => $faker->safeEmail,
        'city_id' => City::where('country_id', \App\Models\Country::EGYPT_ID)->first() ? City::where('country_id', Country::EGYPT_ID)->inRandomOrder()->first()->id : 1023 //cairo
    ];
});
