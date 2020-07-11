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
    
    /** @test */
    function a_retweet_can_be_seen_by_anyone_who_follows_the_user_who_is_retweeting()
    {
        // Given we are sing in and followed a user
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();
        $user->follow($userToFollow);

        // When this user retweet a tweet form a user that we don't follow
        $userWeDontFollow = factory('App\User')->create();
        $userToFollow->follow($userWeDontFollow);

        $tweet = factory('App\Tweet')->create(['user_id' => $userWeDontFollow]);

        $retweet = factory('App\Retweet')->create([
            'user_id' => $userToFollow->id,
            'tweet_id' => $tweet->id
        ]);
        

        // When we hit the homepage /tweets

        $response = $this->get('/tweets');

        // Then we should be able to see the tweet from the person we don't follow as it is retweeted by a user that we follow
        $response->assertSee($retweet->tweet->body);

    }
}
