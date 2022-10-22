
<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Notification;
use Faker\Generator as Faker;

$factory->define(Notification::class, function (Faker $faker) {
    return [
        'id' => \Illuminate\Support\Str::random(30),
        'type' => 'App\Notifications\TestNotification',
        'notifiable_type' => 'App\Models\User',
        'notifiable_id' => 1,
        'data' => '{"message":"This is a message from test notification","url":"http:\/\/localhost:8082\/employees"}'
    ];
});
