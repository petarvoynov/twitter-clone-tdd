<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetweetsTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
    function a_tweet_can_be_retweeted()
    {
        $this->withoutExceptionHandling();
        // Given we are sign in and follow a user who has a tweet
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();

        $tweet = factory('App\Tweet')->create(['user_id' => $userToFollow->id]);

        $user->follow($userToFollow);

        // When we hit the route to retweet the tweet
        $this->post('/retweets/'. $tweet->id);

        // Then there should be a record in the database
        $this->assertDatabaseHas('retweets', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id
        ]);
    }

    /** @test */
    function a_retweet_can_be_destroyed()
    {
        $this->withoutExceptionHandling();
        // Given we are sign in and follow a user who has a tweet that we retweeted
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();

        $tweet = factory('App\Tweet')->create(['user_id' => $userToFollow->id]);

        $user->follow($userToFollow);

        $tweet->retweet();

        //When we hit the route to destroy the retweet
        $this->delete('/retweets/'. $tweet->id);

        // Then there should be no records in the database
        $this->assertDatabaseMissing('retweets', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id
        ]);

    }
}
