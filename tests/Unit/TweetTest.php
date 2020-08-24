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

    /** @test */
    public function a_tweet_has_likes()
    {
        $tweet = factory('App\Tweet')->create();

        $this->assertInstanceOf(Collection::class, $tweet->likes);
    }

    /** @test */
    function a_tweet_can_call_like_method()
    {
        // Given we are sign in and have a tweet
        $user = factory('App\User')->create();
        $this->be($user);

        $tweet = factory('App\Tweet')->create();

        // When we call the method to like the tweet
        $tweet->like();

        // Then there should be record in the database
        $this->assertCount(1, $tweet->likes);
    }

    /** @test */
    function a_tweet_can_call_unlike_method()
    {
        // Given we are sign in and have a tweet that we liked already
        $user = factory('App\User')->create();
        $this->be($user);

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        $tweet->like();

        // When we call the unlike method on the tweet
        $tweet->unlike();

        // Then there should not be records in the database
        $this->assertCount(0, $tweet->likes);
    }

    /** @test */
    function a_tweet_has_retweets()
    {
        $tweet = factory('App\Tweet')->create();

        $this->assertInstanceOf(Collection::class, $tweet->retweets);
    }

    /** @test */
    function a_tweet_can_call_retweet_method()
    {
        // Given we are sign in and follow a user who has a tweet
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();

        $tweet = factory('App\Tweet')->create(['user_id' => $userToFollow->id]);

        // When a tweet call the method retweet()
        $tweet->retweet();

        // Then there should be record in the database
        $this->assertCount(1, $tweet->retweets);

    }

    /** @test */
    function a_tweet_has_morph_many_activities()
    {
        $tweet = factory('App\Tweet')->create();

        $this->assertInstanceOf(Collection::class, $tweet->activities);
    }

    /** @test */
    function a_tweet_has_many_bookmarks()
    {
        $tweet = factory('App\Tweet')->create();

        $this->assertInstanceOf(Collection::class, $tweet->bookmarks);
    }
}
