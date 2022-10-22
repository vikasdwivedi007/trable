<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\JobFile;
use Faker\Generator as Faker;

$factory->define(JobFile::class, function (Faker $faker) {
    return [
        'created_by' => 1,
        'file_no' => rand(2, 99).' 20',
        'command_no' => rand(1111, 9999),
        'travel_agent_id' => \App\Models\TravelAgent::first() ? \App\Models\TravelAgent::inRandomOrder()->first()->id : '',
        'client_name' => $faker->name,
        'client_phone' => $faker->e164PhoneNumber,
        'country_id' => \App\Models\Country::first() ? \App\Models\Country::inRandomOrder()->first() : "",
        'adults_count' => rand(1, 3),
        'children_count' => rand(0, 2),
        'language_id' => \App\Models\Language::first() ? \App\Models\Language::inRandomOrder()->first() : "",
        'arrival_date' => \Carbon\Carbon::now()->addMonth(),
        'departure_date' => \Carbon\Carbon::now()->addMonth()->addWeek(),
        'airport_from' => \App\Models\Airport::first() ? \App\Models\Airport::inRandomOrder()->first() : "",
        'airport_to' => \App\Models\Airport::first() ? \App\Models\Airport::inRandomOrder()->first() : "",
        'request_date' => \Carbon\Carbon::now(),
        'profiling' => $faker->text,
        'remarks' => $faker->text,
        'gifts' => $faker->text,
        'notify_police' => rand(0,1),
        'service_conciergerie' => rand(0,1),
        'router' => rand(0,1),
        'proforma' => rand(0,1)
    ];
});
