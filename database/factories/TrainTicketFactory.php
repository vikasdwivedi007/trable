<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TrainTicket;
use Faker\Generator as Faker;

$factory->define(TrainTicket::class, function (Faker $faker) {
    return [
        'type' => rand(1, 2),
        'number' => rand(1111, 9999),
        'wagon_no' => rand(1111, 9999),
        'seat_no' => rand(1111, 9999),
        'class' => rand(1, 2),
        'currency' => rand(1, 3),
        'sgl_buy_price' => rand(100, 9999),
        'sgl_sell_price' => rand(100, 9999),
        'dbl_buy_price' => rand(100, 9999),
        'dbl_sell_price' => rand(100, 9999),
        'from_station_id' => \App\Models\TrainStation::first() ? \App\Models\TrainStation::inRandomOrder()->first()->id : 1,
        'to_station_id' => \App\Models\TrainStation::first() ? \App\Models\TrainStation::inRandomOrder()->first()->id : 1,
        'depart_at' => \Carbon\Carbon::now(),
        'arrive_at' => \Carbon\Carbon::now()->addDay()->addHours(4)->addMinutes(35),
    ];
});
