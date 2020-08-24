<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Tweet;

class BookmarksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_bookmark_a_tweet()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in and follow a users that has a tweet
        $user = $this->signIn();

        $userToFollow = factory(User::class)->create();

        $tweet = factory(Tweet::class)->create(['user_id' => $userToFollow->id]);
        
        $user->follow($userToFollow);

        // When we hit the route to bookmark this tweet
        $this->post("/tweets/{$tweet->id}/bookmark");

        // Then there should be a record in the database
        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id
        ]);
    }

    /** @test */
    function a_user_cannot_bookmark_the_same_tweet_more_than_once()
    {
        // Given we are sing in and have a tweet
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        // When we hit the route to bookmark the tweet more than once
        $this->post("/tweets/{$tweet->id}/bookmark");
        $this->post("/tweets/{$tweet->id}/bookmark");
        $this->post("/tweets/{$tweet->id}/bookmark");

        // Then there should be one record in the database for bookmarking this tweet
        $this->assertEquals(1, $tweet->bookmarks->count());
    }
}
