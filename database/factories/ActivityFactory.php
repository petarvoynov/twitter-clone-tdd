<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Activity;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User'),
        'subject_id' => factory('App\Tweet'),
        'subject_type' => 'App\Tweet',
        'description' => 'like'
    ];
});
