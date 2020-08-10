<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TwitterList;
use Faker\Generator as Faker;

$factory->define(TwitterList::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph,
        'is_private' => 1 
    ];
});
