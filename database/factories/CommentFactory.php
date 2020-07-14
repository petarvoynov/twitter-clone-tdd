<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User'),
        'tweet_id' => factory('App\Tweet'),
        'body' => $faker->sentence
    ];
});
