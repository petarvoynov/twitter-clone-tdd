<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeTweetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_tweet_can_be_liked()
    {
        // Given we are sign in and have a tweet
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        // When we hit the route to like the tweet
        $this->post('/tweets/' . $tweet->id.'/like');

        // Then there should be record in the database
        $this->assertCount(1, $tweet->likes);
        $this->assertDatabaseHas('likes', [
            'user_id' => auth()->id(),
            'likeable_id' => $tweet->id,
            'likeable_type' => get_class($tweet)
        ]);
    }

    /** @test */
    function a_tweet_cannot_be_liked_more_than_once()
    {
        // Given we are sign in and have a tweet
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        // When we hit the route to like the tweet more than once
        $this->post('/tweets/'. $tweet->id .'/like');
        $this->post('/tweets/'. $tweet->id .'/like');

        // Then there should be only one record in the database
        $this->assertCount(1, $tweet->likes);
    }

    /** @test */
    function a_tweet_can_be_unliked()
    {
        // Given we are sign in and have a tweet that we like
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        $tweet->like();

        // When we hit the route to unlike the tweet
        $this->delete('/tweets/'. $tweet->id .'/unlike');

        // Then there should not be records in the database
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'likeable_id' => $tweet->id,
            'likeable_type' => 'App\Tweet'
        ]);
    }
}
