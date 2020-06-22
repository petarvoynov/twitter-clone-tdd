<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class TweetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_tweet_belongs_to_a_user()
    {
        $tweet = factory('App\Tweet')->create();

        $this->assertInstanceOf('App\User', $tweet->user);
    }

    /** @test */
    function a_tweet_has_many_comments()
    {
        $tweet = factory('App\Tweet')->create();

        $this->assertInstanceOf(Collection::class, $tweet->comments);
    }
}
