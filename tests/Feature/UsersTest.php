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
        // Given are sign in and we have a user to follow
        $user = $this->signIn();

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
        $user = $this->signIn();

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
        $user = $this->signIn();

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
        $user = $this->signIn();

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
        $user = $this->signIn();

        $userWeDontFollow = factory('App\User')->create();

        $tweet = factory('App\Tweet')->create(['user_id' => $userWeDontFollow]);

        // When we hit the route to see his profile
        $response = $this->get('/users/' . $userWeDontFollow->id);

        // We should not be able to see the tweet
        $response->assertDontSee($tweet->body);
    }

    /** @test */
    function a_user_records_activity_when_he_makes_a_tweet()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in
        $user = $this->signIn();

        // When we post a tweet
        $tweet = factory('App\Tweet')->raw(['user_id' => $user->id]);
        $this->post('/tweets', $tweet);

        // Then there should be record in the activity table for posting that tweet
        $this->assertCount(1, $user->activities);
        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
            'description' => 'created a tweet'
        ]);
    }

    /** @test */
    function a_user_records_activity_when_he_likes_a_tweet()
    {
        // Given we are sing in and have a tweet
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);
        
        // When we hit the route to like the tweet
        $this->post('/tweets/'. $tweet->id .'/like');

        // Then there should be one activity in the database for liking the tweet
        $this->assertCount(1, $user->activities);
        $this->assertEquals('this tweet is being liked', $user->activities->first()->description);
    }

    /** @test */
    function a_user_destroys_activity_when_he_unlikes_a_tweet()
    {
        // Given we are sing in and have a tweet that we like
        $user = $this->signIn();

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
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        // When we hit the route to comment the tweet
        $comment = factory('App\Comment')->create([
            'tweet_id' => $tweet->id,
            'user_id' => $user->id
        ]);
        $this->post('/tweets/'. $tweet->id .'/comments', $comment->toArray());

        // Then there should be records in the activity table for commenting the tweet
        $this->assertCount(1, $user->activities);
        $this->assertEquals('commented a tweet', $user->activities->first()->description);
    }

    /** @test */
    function a_user_destroys_activity_when_he_deletes_his_comment()
    {
        // Given we are sign in and have a comment
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        // When we hit the route to comment the tweet
        $comment = factory('App\Comment')->make([
            'tweet_id' => $tweet->id,
            'user_id' => $user->id
        ]);

        $this->post('/tweets/'. $tweet->id .'/comments', $comment->toArray());
        $comment = \App\Comment::first();

        // When we hit the route to delete this comment
        $this->delete('/tweets/'. $comment->tweet->id .'/comments/'. $comment->id);

        // Then there shouldn't be a record in activities table for creating the comment
        $this->assertDatabaseMissing('activities', [
            'user_id' => $user->id,
            'description' => 'comment'
        ]);
    }

    /** @test */
    function a_user_records_activity_when_he_retweet_a_tweet()
    {
        // Given we are sign in 
        $user = $this->signIn();

        // And there is a user that we follow and has a tweet
        $userToFollow = factory('App\User')->create();
        $tweet = factory('App\Tweet')->create(['user_id' => $userToFollow->id]);

        $user->follow($userToFollow);

        // When we hit the route to retweet that tweet
        $this->post('/retweets/' . $tweet->id);

        // Then there should be retweet activity for us in the database
        $this->assertCount(1, $user->activities);
        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
            'description' => 'this tweet is being retweeted'
        ]);

    }

    /** @test */
    function a_user_destroys_activity_when_he_remove_his_retweet()
    {
        // Given we are sign in 
        $user = $this->signIn();

        // And there is a user that we follow and has a tweet that we retweet
        $userToFollow = factory('App\User')->create();
        $tweet = factory('App\Tweet')->create(['user_id' => $userToFollow->id]);

        $user->follow($userToFollow); 

        $this->post('/retweets/' . $tweet->id);

        // When we hit the route to delete this retweet
        $this->delete('/retweets/' . $tweet->id);

        // Then there shouldn't be a record in activities table for retweeting the tweet
        $this->assertDatabaseMissing('activities', [
            'user_id' => $user->id,
            'description' => 'retweet'
        ]);
    }

    /** @test */
    function a_user_records_activity_when_he_likes_comment()
    {
        // Given we are sign in and have a comment
        $user = $this->signIn();
        
        $comment = factory('App\Comment')->create(['user_id' => $user->id]);

        // When we hit the route to like that comment
        $this->post('/comments/'. $comment->id .'/like');

        // Then there should be a record in the activity table for liking this comment
        $this->assertCount(1, $user->activities);
        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
            'subject_id' => $comment->id,
            'subject_type' => get_class($comment),
            'description' => 'this comment is being liked'
        ]);
    }

    /** @test */
    function a_user_destroys_activity_when_he_unlikes_a_comment()
    {
        // Given we are sign in and have a comment that we liked
        $user = $this->signIn();
        
        $comment = factory('App\Comment')->create(['user_id' => $user->id]);

        $this->post('/comments/'. $comment->id .'/like');

        // When we hit the route ot unlike the comment
        $this->delete('/comments/'. $comment->id .'/unlike');
        
        // Then there shouldn't be records in activity table for liking the comment
        $this->assertCount(0, $user->activities);
        $this->assertDatabaseMissing('activities', [
            'user_id' => $user->id,
            'subject_id' => $comment->id,
            'subject_type' => get_class($comment),
            'description' => 'like'
        ]);
    }

    /** @test */
    function a_user_can_update_their_profile()
    {
        // Given we are sing in
        $user = $this->signIn();
        
        // When we hit the route to update our profile
        $this->patch('/users/' . $user->id, [
            'name' => $user->name,
            'description' => 'fake description',
            'location' => 'fake location'
        ]);

        // Then the profile should be updated in the database
        $this->assertDatabaseHas('users', [
            'description' => 'fake description',
            'location' => 'fake location'
        ]);
    }

    /** @test */
    function an_authenticated_user_cannot_update_the_profile_picture_of_another_user()
    {
        // Given we are sign in
        $user = $this->signIn();

        // When we try to update the image of another user
        $anotherUser = factory('App\User')->create(['profile_picture' => 'default.jpg']);

        $this->post("/users/{$anotherUser->id}/profile-picture", [
            'profile_picture' => 'changed.jpg'
        ]);

        // Then there shouldn't be a record for having an profile picture in the database for the other user
        $this->assertDatabaseMissing('users', [
            'id' => $anotherUser->id,
            'profile_picture' => 'changed.jpg'
        ]);
    }

    /** @test */
    function an_authenticated_user_cannot_update_the_profile_of_another_user()
    {
        // When we try to update someone else profile we change ours
        
        // Given we are sing in
        $user = $this->signIn();

        // When we hit the route to update the profile of another user
        $anotherUser = factory('App\User')->create([
            'description' => 'description',
            'location' => 'location'
        ]);
        $this->patch("/users/{$anotherUser->id}", [
            'name' => 'name',
            'description' => 'changed description',
            'location' => 'changed location'
        ]);

        // Then there should not be records in the database for changing his profile
        $this->assertDatabaseMissing('users', [
            'id' => $anotherUser->id,
            'description' => 'changed description',
            'location' => 'changed location'
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'description' => 'changed description',
            'location' => 'changed location'
        ]);
    }

    /** @test */
    function an_authenticated_user_can_subscribe_for_notifications_about_tweets_being_created_by_a_user_he_follows()
    {
        $this->withoutExceptionHandling();
        // Given we are sign in and follow a user
        $user = $this->signIn();
        $userToFollow = factory('App\User')->create();

        $user->follow($userToFollow);

        // When we hit the route to subscribe for notifications for this user's tweets
        $this->post("/users/{$userToFollow->id}/subscribe");

        // Then there should be a record in the database
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'subscribed_to' => $userToFollow->id
        ]);
    }
}
