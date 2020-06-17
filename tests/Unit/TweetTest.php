<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
