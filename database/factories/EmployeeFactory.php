<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee;
use \App\Models\City;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'salary' => rand(10000, 50000),
        'commission' => 10.2,
        'gender' => rand(0,1),
        'outsource' => rand(0,1),
        'supervisor_id' => null,
        'user_id' => factory(\App\Models\User::class),
        'department_id' => \App\Models\Department::first() ? \App\Models\Department::first()->id : factory(\App\Models\Department::class),
        'job_id' => 1,
        'hired_at' => \Carbon\Carbon::now()->subYears(1),
        'promoted_at' => \Carbon\Carbon::now()->subYears(3),
        'city_id' => City::first() ? City::first()->id : factory(City::class),
        'active' => 1,
        'points' => rand(1, 100)
    ];
});
