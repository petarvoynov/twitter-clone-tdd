<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_message_people_that_are_following_him()
    {
        $this->withoutExceptionHandling();
        // Give we are sing in and have user that follow us
        $user = $this->signIn();

        $userToFollowUs = factory('App\User')->create();

        $userToFollowUs->follow($user);

        // When we hit the route to start a conversation (should recive response 200)
        $this->get("/messages/{$userToFollowUs->id}")
            ->assertStatus(200);

        // and send a message
        $this->post("/messages/{$userToFollowUs->id}", ['message' => 'Hello']);

        // Then he should recive the message
        $this->assertDatabaseHas('messages', [
            'from' => $user->id,
            'to' => $userToFollowUs->id,
            'message' => 'Hello'
        ]);
    }

    /** @test */
    function a_user_cannot_message_people_that_are_not_following_him()
    {
        // Given we are sing in
        $user = $this->signIn();

        $userToMessage = factory('App\User')->create();

        // When we try to message a user that doesn't follow us
        $response = $this->post("/messages/{$userToMessage->id}",['message' => 'this should not be saved']);

        // Then there should not be a record in the database and should receive response 403
        $response->assertStatus(403);

        $this->assertDataBaseMissing('messages', [
            'message' => 'this should not be saved'
        ]);
    }

    /** @test */
    function a_user_can_visit_the_page_to_see_all_his_started_conversations()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in
        $user = $this->signIn();

        // When we visit the page to see our conversations
        $response = $this->get('/messages');

        // We shoud see the title of the page "Your Conversations"
        $response->assertSee('All Conversations');
    }
}
