<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'tweet_id' => factory('App\Tweet'),
        'body' => $faker->sentence
    ];
});
