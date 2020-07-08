<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class RetweetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_retweet_has_comments()
    {
        $retweet = factory('App\Retweet')->create();

        $this->assertInstanceOf(Collection::class, $retweet->comments);
    }

    /** @test */
    function a_retweet_belongs_to_a_tweet()
    {
        $retweet = factory('App\Retweet')->create();

        $this->assertInstanceOf('App\Tweet', $retweet->tweet);
    }

    /** @test */
    function a_retweet_belongs_to_a_user()
    {
        $retweet = factory('App\Retweet')->create();

        $this->assertInstanceOf('App\User', $retweet->user);
    }
}
