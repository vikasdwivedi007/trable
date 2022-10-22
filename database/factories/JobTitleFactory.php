<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\JobTitle;
use Faker\Generator as Faker;

$factory->define(JobTitle::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->jobTitle,
        'can_be_assigned' => $faker->numberBetween(0,1),
    ];
});
