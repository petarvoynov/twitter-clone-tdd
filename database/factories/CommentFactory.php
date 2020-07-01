<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User'),
        'commentable_id' => factory('App\Tweet'),
        'commentable_type' => get_class(factory('App\Tweet')->create()),
        'body' => $faker->sentence
    ];
});
