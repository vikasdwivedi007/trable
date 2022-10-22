<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Airport;
use Faker\Generator as Faker;

$factory->define(Airport::class, function (Faker $faker) {
    return [
        'icao' => \Illuminate\Support\Str::random(4),
        'iata' => \Illuminate\Support\Str::random(3),
        'name' => $faker->company,
        'city' => $faker->city,
        'state' => $faker->state,
        'country' => $faker->country,
        'timezone' => 'Afica/Cairo'
    ];
});
