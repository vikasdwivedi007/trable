<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Guide;
use Faker\Generator as Faker;

$factory->define(Guide::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => rand(1111111111, 9999999999),
        'license_no' => rand(1111111111, 9999999999),
        'city_id' => \App\Models\City::first() ? \App\Models\City::inRandomOrder()->first()->id : factory(\App\Models\City::class)->create()->id,
        'daily_fee' => rand(500, 1000),
    ];
});
