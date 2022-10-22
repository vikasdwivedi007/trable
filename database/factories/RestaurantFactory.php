<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Restaurant;
use Faker\Generator as Faker;

$factory->define(Restaurant::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'phone' => $faker->e164PhoneNumber,
        'address' => $faker->address,
        'city_id' => \App\Models\City::first() ? \App\Models\City::inRandomOrder()->first()->id : factory(\App\Models\City::class)->create(),
    ];
});
