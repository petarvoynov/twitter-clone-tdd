<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TweetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_cannot_see_create_update_or_delete_tweets()
    {
        $this->get('/tweets')->assertRedirect('login');
        $this->post('/tweets', [])->assertRedirect('login');

        $tweet = factory('App\Tweet')->create();

        $this->patch('/tweets/' . $tweet->id, [])->assertRedirect('login');
        $this->delete('/tweets/' . $tweet->id)->assertRedirect('login');
    }

    /** @test */
    function an_authenticated_user_can_see_all_tweets_of_users_he_follows()
    {   
        // Given we are sign in
        $user = $this->signIn();

        // Given there is a tweet from a user that I follow
        $userToFollow = factory('App\User')->create();
        $user->follow($userToFollow);

        $tweet = factory('App\Tweet')->create(['user_id' => $userToFollow->id]);
        $tweet->activities()->create([
            'user_id' => $userToFollow->id,
            'description' => 'created a tweet'
        ]);
        
        // When a user goes to his homepage
        $response = $this->get('/tweets');
            
        // Then he should be able to see the tweets
        $response->assertSee($tweet->body);
    }

    /** @test */
    function a_user_can_see_a_single_tweet()
    {
        // Given we are sign in and have a tweet
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        // When we hit the route to see that tweet
        $response = $this->get('/tweets/' . $tweet->id);

        // Then we should see the tweet body
        $response->assertSee($tweet->body);
    }

    /** @test */
    function an_authenticated_user_cannot_see_tweets_of_users_he_doesnt_follow()
    {   
        // Given we are sign in
        $user = $this->signIn();

        // Given there is a tweet from a user that we don't follow
        $userWeDontFollow = factory('App\User')->create();

        $tweet = factory('App\Tweet')->create(['user_id' => $userWeDontFollow->id]);

        // When we go to our homepage to see all tweets
        $response = $this->get('/tweets');
            
        // Then we should not be able to see the tweet
        $response->assertDontSee($tweet->body);
    }

    /** @test */
    function an_authenticated_user_can_create_tweets()
    {
        // Given we are signed in
        $user = $this->signIn();

        $tweet = ['body' => 'test tweet'];

        // When we hit the route to store a tweet
        $response = $this->post('/tweets', $tweet)
            ->assertRedirect('/tweets');

        // Then we should see it saved to the database
        $this->assertDatabaseHas('tweets', $tweet);
    }

    /** @test */
    function an_authenticated_user_can_update_his_own_tweet()
    {
        // Given we are sign in and we have a tweet
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);

        // When we hit the route to edit the tweet
        $this->patch('/tweets/' . $tweet->id, ['body' => 'changed'])
            ->assertRedirect('/tweets');

        // Then we should see the changes in the database
        $this->assertDatabaseHas('tweets', ['body' => 'changed']);
    }

    /** @test */
    function an_authenticated_user_can_delete_his_own_tweet()
    {
        // Given we have a sign in user and he has a tweet
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);
        
        // When he hits the route to delete the tweet
        $response = $this->delete('/tweets/' . $tweet->id);

        // Then the tweet has to be removed from the database
        $this->assertDeleted('tweets', $tweet->toArray());

        $response->assertRedirect('/tweets');
    }

    /** @test */
    function an_authenticated_user_cannot_update_the_tweet_of_others()
    {
        // Given we have a sign in user and a tweet not created by him
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create();

        // When he hits the route to update the tweet
        $response = $this->patch('/tweets/' . $tweet->id, ['body' => 'changed']);

        // Then he should recieve a 403 response
        $response->assertStatus(403);
    }   

    /** @test */
    function an_authenticated_user_cannot_delete_tweet_of_others()
    {
        // Given we have a sing in user and a tweet that doesn't belongs to him
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create();

        // When he hits the route to delete this tweet
        $response = $this->delete('/tweets/' . $tweet->id);

        // Then he should recieve a 403 response
        $response->assertStatus(403);
    }

    /** @test */
    function a_tweet_requires_a_body()
    {
        $user = $this->signIn();

        $tweet = factory('App\Tweet')->create(['body' => '']);

        $this->post('/tweets', $tweet->toArray())->assertSessionHasErrors('body');
        $this->patch('/tweets/' . $tweet->id, $tweet->toArray())->assertSessionHasErrors('body');
    }
}
