<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TwitterList;
use Faker\Generator as Faker;

$factory->define(TwitterList::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User'),
        'name' => $faker->name,
        'description' => $faker->paragraph,
    ];
});
