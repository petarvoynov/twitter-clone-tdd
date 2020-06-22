<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TweetCommnetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_tweet_can_have_comments()
    {
        $this->withoutExceptionHandling();
        // Given we are sign in and have a tweet
        $user = factory('App\User')->create();
        $this->be($user);

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        // When a user hit the route to post a comment
        $comment = ['body' => 'test comment'];
        $this->post('/tweets/' . $tweet->id . '/comments', $comment);

        // Then there should be a comment associated with this tweet in the database
        $this->assertDatabaseHas('comments', $comment);
    }
}
