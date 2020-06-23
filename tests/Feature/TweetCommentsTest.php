<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TweetCommentsTest extends TestCase
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
        $comment = factory('App\Comment')->create();
        $this->post('/tweets/' . $tweet->id . '/comments', $comment->toArray());

        // Then there should be a comment associated with this tweet in the database
        $this->assertDatabaseHas('comments', $comment->toArray());
    }

    /** @test */
    function a_comment_requires_a_body()
    {
        // Given we are sign in and have a tweet 
        $user = factory('App\User')->create();
        $this->be($user);
        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);
        
        // When we post an empty comment for that tweet
        $comment = factory('App\Comment')->create(['body' => '']);
        $response = $this->post('/tweets/' . $tweet->id . '/comments', $comment->toArray());

        //Then we should recieve an validation error
        $response->assertSessionHasErrors('body');
    }
}
