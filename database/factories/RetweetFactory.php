<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Retweet;
use Faker\Generator as Faker;

$factory->define(Retweet::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User'),
        'tweet_id' => factory('App\Tweet')
    ];
});
