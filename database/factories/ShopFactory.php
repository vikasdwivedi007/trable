<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Shop;
use Faker\Generator as Faker;

$factory->define(Shop::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'phone' => $faker->e164PhoneNumber,
        'city_id' => \App\Models\City::first() ? \App\Models\City::first()->id : factory(\App\Models\City::class)->create()->id,
        'commission' => rand(1, 100) / 100,
        'address' => $faker->address
    ];
});
