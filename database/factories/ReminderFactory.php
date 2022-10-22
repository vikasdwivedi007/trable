<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Reminder;
use Faker\Generator as Faker;

$factory->define(Reminder::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(6, true),
        'desc' => $faker->sentence(15, true),
        'assigned_by_id' => 1,
        'assigned_to_id' => 1,
        'status' => 0,
        'send_at' => Carbon\Carbon::now()->addHour(),
        'send_by' => ['db', 'mail'],
    ];
});
