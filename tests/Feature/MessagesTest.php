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
}
