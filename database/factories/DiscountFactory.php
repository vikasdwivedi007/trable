<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Discount;
use Faker\Generator as Faker;

$factory->define(Discount::class, function (Faker $faker) {
    return [
        //will remove discount_ in model
        'discount_type' => rand(1,2),
        'discount_value' => $faker->randomNumber(2)/100
    ];
});
