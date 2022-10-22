<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\RoomDetails;
use App\Models\Room;
use Faker\Generator as Faker;

$factory->define(RoomDetails::class, function (Faker $faker) {
    return [
        'room_id' => factory(Room::class)->create()->id,
        'base_rate' => rand(100, 1000),
        'base_rate_currency' => rand(1,3),
        'price_valid_from' => Carbon\Carbon::now()->subMonth(),
        'price_valid_to' => Carbon\Carbon::now()->addMonths(4),
        'extra_bed_exc' => rand(100, 1000),
        'child_free_until' => $faker->randomDigitNot(0),
        'child_with_two_parents_exc' => rand(100, 1000),
        'max_children_with_two_parents' => rand(1, 10),
        'single_parent_exc' => rand(100, 1000),
        'single_parent_child_exc' => rand(100, 1000),
        'min_child_age' => 1,
        'max_child_age' => 10,
        'special_offer' => $faker->text,
    ];
});
