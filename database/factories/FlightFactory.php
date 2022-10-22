<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Flight;
use Faker\Generator as Faker;

$factory->define(Flight::class, function (Faker $faker) {
    return [
        'number' => rand(1111,9999),
        'date' => \Carbon\Carbon::now()->addDay()->format('l d F Y'),
        'from' => \App\Models\Airport::where('country', 'EG')->first() ? \App\Models\Airport::where('country', 'EG')->inRandomOrder()->first()->id : 1,
        'to' => \App\Models\Airport::where('country', 'EG')->first() ? \App\Models\Airport::where('country', 'EG')->inRandomOrder()->first()->id : 1,
        'depart_at' => \Carbon\Carbon::now()->addDay()->format("H:i"),
        'arrive_at' => \Carbon\Carbon::now()->addDay()->addHours(3)->addMinutes(24)->format("H:i"),
        'reference' => \Illuminate\Support\Str::random(10),
        'seats_count' => rand(1, 10),
        'status' => rand(1, 2),
        'buy_price' => rand(100, 200),
        'sell_price_vat_exc' => rand(200, 300),
        'buy_price_currency' => rand(1, 3),
        'sell_price_vat_exc_currency' => rand(1, 3),
    ];
});
