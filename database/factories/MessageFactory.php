<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'from' => factory('App\User'),
        'to' => factory('App\User'),
        'message' => $faker->sentence(15)
    ];
});
