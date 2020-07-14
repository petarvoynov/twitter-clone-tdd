<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_follow_another_user()
    {
        $this->withoutExceptionHandling();
        // Given are sign in and we have a user to follow
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();

        // When he hit the route to follow another user
        $this->post('/users/'. $userToFollow->id .'/follow');

        $user->refresh();
        // Then when we call the relationship we should have one record
        $this->assertCount(1, $user->followings);

        // Then when we call the relationship we have to have it in the results
        $this->assertTrue($user->followings->contains($userToFollow));
    }

    /** @test */
    function a_user_can_unfollow_a_followed_user()
    {
        // Given are sign in and already followed a user
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();
        $this->post('/users/'. $userToFollow->id .'/follow');

        // When we hit the route to unfollow this user
        $this->post('/users/'. $userToFollow->id .'/unfollow');

        //Then when we call the relationship we should have no records
        $this->assertCount(0, $user->followings);
    }
    
   
    /** @test */
    function a_user_cannot_follow_a_user_if_he_is_already_following_him()
    {
        // Given we are sign in and have followed a user
        $user = factory('App\User')->create();
        $this->be($user);

        $userToFollow = factory('App\User')->create();

        $user->follow($userToFollow);

        // When we hit the route to follow him again

        $this->post('/users/' . $userToFollow->id . '/follow');

        // Then we should not have anoter record of following this user
        $this->assertCount(1, $user->followings);
    }

    /** @test */
    function a_user_cannot_unfollow_a_user_that_he_is_not_following()
    {
        // Given we are sign in and there is a user that we don't follow
        $user = factory('App\User')->create();
        $this->be($user);

        $userWeDontFollow = factory('App\User')->create();
        
        // When we hit the route to unfollow him 
        $response = $this->post('/users/' . $userWeDontFollow->id . '/unfollow');

        // Then we should recieve a response 403
        $response->assertStatus(403);
    }

    /** @test */
    function a_user_cannot_see_tweets_of_another_user_that_he_is_not_following()
    {
        // Given we are sign in and there is a user we don't follow and that has a tweet
        $user = factory('App\User')->create();
        $this->be($user);

        $userWeDontFollow = factory('App\User')->create();

        $tweet = factory('App\Tweet')->create(['user_id' => $userWeDontFollow]);

        // When we hit the route to see his profile
        $response = $this->get('/users/' . $userWeDontFollow->id);

        // We should not be able to see the tweet
        $response->assertDontSee($tweet->body);
    }

    /** @test */
    function a_user_records_activity_when_he_likes_a_tweet()
    {
        // Given we are sing in and have a tweet
        $user = factory('App\User')->create();
        $this->be($user);

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);
        
        // When we hit the route to like the tweet
        $this->post('/tweets/'. $tweet->id .'/like');

        // Then there should be one activity in the database for liking the tweet
        $this->assertCount(1, $user->activities);
        $this->assertEquals('like', $user->activities->first()->description);
    }

    /** @test */
    function a_user_destroys_activity_when_he_unlikes_a_tweet()
    {
        // Given we are sing in and have a tweet that we like
        $user = factory('App\User')->create();
        $this->be($user);

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);
        $this->post('/tweets/'. $tweet->id .'/like');

        // When we hit the route to unlike the tweet
        $this->delete('/tweets/'. $tweet->id .'/unlike');

        // Then there should not be activity in the database
        $this->assertCount(0, $user->activities);
    }

    /** @test */
    function a_user_records_activity_when_he_comment_a_tweet()
    {
        // Given we are sing in and have a tweet
        $user = factory('App\User')->create();
        $this->be($user);

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        // When we hit the route to comment the tweet
        $comment = factory('App\Comment')->create([
            'tweet_id' => $tweet->id,
            'user_id' => $user->id
        ]);
        $this->post('/tweets/'. $tweet->id .'/comments', $comment->toArray());

        // Then there should be records in the activity table for commenting the tweet
        $this->assertCount(1, $user->activities);
        $this->assertEquals('comment', $user->activities->first()->description);
    }
}
