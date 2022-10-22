<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Room;
use App\Models\Hotel;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    $views = ['Garden Vie', 'Nile View', 'Pool View', 'Pyramids View'];
    return [
        'hotel_id' => Hotel::inRandomOrder()->first()->id,
        'name' => $faker->name,
        'type' => rand(1, 8),
        'meal_plan' => rand(1, 4),
        'view' => $views[rand(0, 3)],
        'info' => $faker->text,
    ];
});
