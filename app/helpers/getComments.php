<?php 

use App\Comment;
use App\Tweet;

function getComments($tweet)
{
    return $tweet->comments()->take(3)->get();
}