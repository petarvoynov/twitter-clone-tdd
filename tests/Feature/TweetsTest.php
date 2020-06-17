<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TweetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_authenticated_user_can_see_all_tweets()
    {   
        // Given we are sign in
        $user = factory('App\User')->create();
        $this->actingAs($user);

        // Given there is a tweet
        $tweet = factory('App\Tweet')->create();

        // When a user goes to his homepage
        $response = $this->get('/tweets');
            
        // Then he should be able to see the tweets
        $response->assertSee($tweet->body);
    }

    /** @test */
    function guests_cannot_see_tweets()
    {
        // Given there is  a tweet
        $tweet = factory('App\Tweet')->create();

        // When a guest goes to the homepage
        $response = $this->get('/tweets');

        // Then he should be redirected to the login page
        $response->assertRedirect('login');
    }

    /** @test */
    function an_authenticated_user_can_create_tweets()
    {
        // Given we are signed in
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $tweet = ['body' => 'test tweet'];

        // When we hit the route to store a tweet
        $response = $this->post('/tweets', $tweet)
            ->assertRedirect('/tweets');

        // Then we should see it saved to the database
        $this->assertDatabaseHas('tweets', $tweet);
    }

    /** @test */
    function guests_cannot_create_tweets()
    {
        // Given there is a guest

        // When he hit the route to store a tweet
        $tweet = ['body' => 'test tweet'];
        $response = $this->post('/tweets', $tweet);

        // Then he should be redirected to the login page
        $response->assertRedirect('login');
    }
}
