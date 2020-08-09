<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

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

    /** @test */
    function an_authenticated_user_can_unsubscribe_for_notifications()
    {
        // Given we are sing in and follow and subscribe to a user
        $user = $this->signIn();

        $userToFollowAndSubscribe = factory('App\User')->create();

        $user->follow($userToFollowAndSubscribe);

        $user->subscribe($userToFollowAndSubscribe);
        
        // When we hit the route to unsubscribe for the user
        $this->delete("/users/{$userToFollowAndSubscribe->id}/unsubscribe");

        // Then there shouldn't be a record in the database
        $this->assertDatabaseMissing('subscriptions', [
            'user_id' => $user->id,
            'subscribed_to' => $userToFollowAndSubscribe->id
        ]);
    }

    /** @test */
    function an_authenticated_user_receives_a_notification_when_a_user_that_he_follows_create_a_tweet()
    {
        // Given we are sing in and follow and subcribe to a user
        $user = factory('App\User')->create();

        $userToFollowAndSubscribe = factory('App\User')->create();

        $user->follow($userToFollowAndSubscribe);

        $user->subscribe($userToFollowAndSubscribe);

        // When this user creates a tweet
        $this->actingAs($userToFollowAndSubscribe)->post('/tweets', [
            'body' => 'This tweet should generate a notification'
        ]);

        // Then there should be a record in the database that we have a notification
        $this->assertDatabaseHas('notifications',[
            'notifiable_id' => $user->id
        ]);
    }

    /** @test */
    function user_can_see_all_his_notifications()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in and follow and subscribe to a user
        $user = factory('App\User')->create();

        $userToFollowAndSubscribe = factory('App\User')->create();

        $user->follow($userToFollowAndSubscribe);

        $user->subscribe($userToFollowAndSubscribe);

        $tweet = factory('App\Tweet')->make(['user_id' => $userToFollowAndSubscribe]);

        // When this user post a tweet and generate us a notification
        $this->actingAs($userToFollowAndSubscribe)->post('/tweets', $tweet->toArray());

        // and we hit the route to see all of our notification
        $response = $this->actingAs($user)->get('/notifications');

        // Then we should be able to see them
        $response->assertSeeInOrder([
            $userToFollowAndSubscribe->name,
            'tweeted:',
            $tweet->body
        ]);
    }

    /** @test */
    function user_can_see_all_his_unread_notifications()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in and follow and subscribe to a user
        $user = factory('App\User')->create();

        $userToFollowAndSubscribe = factory('App\User')->create();

        $user->follow($userToFollowAndSubscribe);

        $user->subscribe($userToFollowAndSubscribe);

        $tweet = factory('App\Tweet')->make(['user_id' => $userToFollowAndSubscribe]);

        // When this user post a tweet and generate us a notification
        $this->actingAs($userToFollowAndSubscribe)->post('/tweets', $tweet->toArray());

        // and we hit the route to see all of our notification
        $response = $this->actingAs($user)->get('/unread-notifications');

        // Then we should be able to see them
        $response->assertSeeInOrder([
            $userToFollowAndSubscribe->name,
            'tweeted:',
            $tweet->body
        ]);
    }

    /** @test */
    function user_can_see_all_his_read_notifications()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in and follow and subscribe to a user
        $user = factory('App\User')->create();

        $userToFollowAndSubscribe = factory('App\User')->create();

        $user->follow($userToFollowAndSubscribe);

        $user->subscribe($userToFollowAndSubscribe);

        $tweet = factory('App\Tweet')->make(['user_id' => $userToFollowAndSubscribe]);

        // When this user post a tweet and generate us a notification
        $this->actingAs($userToFollowAndSubscribe)->post('/tweets', $tweet->toArray());

        $user->notifications->first()->markAsRead();

        // and we hit the route to see all of our notification
        $response = $this->actingAs($user)->get('/read-notifications');

        // Then we should be able to see them
        $response->assertSeeInOrder([
            $userToFollowAndSubscribe->name,
            'tweeted:',
            $tweet->body
        ]);
    }
}
