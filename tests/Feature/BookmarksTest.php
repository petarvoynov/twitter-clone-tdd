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
}
