<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Transportation;
use Faker\Generator as Faker;

$factory->define(Transportation::class, function (Faker $faker) {
    return [
        'code' => \Illuminate\Support\Str::random(10),
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'phone' => $faker->e164PhoneNumber,
        'city_id' => \App\Models\City::first() ? \App\Models\City::inRandomOrder()->first()->id : factory(\App\Models\City::class)->create(),
    ];
});
