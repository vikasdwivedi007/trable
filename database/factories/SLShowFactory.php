<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SLShow;
use Faker\Generator as Faker;

$factory->define(SLShow::class, function (Faker $faker) {
    $places = ['Pyramids', 'Karnak', 'Edfu', 'Philae', 'Abu Simbel'];
    $types = ['Regular', 'VIP'];
    return [
        'date' => \Carbon\Carbon::now()->format('l d F Y'),
        'time' => \Carbon\Carbon::now()->format('H:i'),
        'currency' => rand(1, 3),
        'place' => $places[rand(0, count($places) - 1)],
        'language_id' => \App\Models\Language::first() ? \App\Models\Language::inRandomOrder()->first()->id : 1,
        'buy_price_adult' => rand(100, 200),
        'sell_price_adult_vat_exc' => rand(200, 300),
        'buy_price_child' => rand(50, 100),
        'sell_price_child_vat_exc' => rand(100, 200),
        'ticket_type' => $types[rand(0, 1)],
    ];
});
