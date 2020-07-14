<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TweetCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_authenticated_user_can_see_the_comments_of_his_or_followings_single_tweet()
    {
        // Given we are sign in and follow a following and this following has a tweet
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();
        $user->follow($userToFollow);

        $followingTweet = factory('App\Tweet')->create(['user_id' => $userToFollow]);

        // When we comment on his tweet
        $this->post('/tweets/' . $followingTweet->id . '/comments', ['body' => 'Our commnet on following tweet']);

        // Then we should be able to see the comment on our tweet and the comment on the following tweet on our tweets page /tweets
        $this->get('/tweets/' . $followingTweet->id)
            ->assertSee('Our commnet on following tweet');
    }

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

    /** @test */
    function a_comment_can_be_destroyed()
    {
        // Given we are sign in and and a comment
        $user = factory('App\User')->create();
        $this->be($user);

        $comment = factory('App\Comment')->create(['user_id' => $user->id]);

        // When we hit the route to delete this comment
        $this->delete('/tweets/' . $comment->tweet->id .'/comments/'. $comment->id); 
        
        // Then there should not be record in the database for that comment
        $this->assertDatabaseMissing('comments', ['body' => $comment->body]);
    }
}
