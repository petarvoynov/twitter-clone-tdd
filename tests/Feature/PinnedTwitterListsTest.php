<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PinnedTwitterListsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_twitter_list_can_be_pinned()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in and have created a list
        $user = $this->signIn();

        $list = factory('App\TwitterList')->create(['user_id' => $user->id]);

        // When we mark it as pinned
        $this->post("/pinned-lists/{$list->id}");

        // Then it should be show in the pinned lists section
        // and this list should have is_pinned column set to 1
        $this->get('/lists')
            ->assertSeeTextInOrder(['Pinned Lists', $list->name, 'Your Lists']);

        $this->assertDatabaseHas('twitter_lists', [
            'user_id' => $user->id,
            'is_pinned' => 1
        ]); 
    }

    /** @test */
    function a_twitter_list_can_be_pinned_only_by_its_owner()
    {
        // Given we are sing in and there is a list created by someone else
        $user = $this->signIn();

        $list = factory('App\TwitterList')->create();

        // When we hit the route to mark it as pinned
        $response = $this->post("/pinned-lists/{$list->id}");

        // Then we should recieve 403 page
        $response->assertStatus(403);

        // and shouldn't have a list that is pinned
        $this->assertDatabaseMissing('twitter_lists', [
            'is_pinned' => 1
        ]); 
    }

    /** @test */
    function a_twitter_list_can_be_unpinned()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in and have a list that is pinned
        $user = $this->signIn();

        $list = factory('App\TwitterList')->create(['user_id' => $user->id, 'is_pinned' => 1]);

        // When we hit the route to unpin it
        $this->delete("/pinned-lists/{$list->id}");

        // Then the list should not be pinned

        $this->assertDatabaseMissing('twitter_lists', [
            'id' => $list->id,
            'is_pinned' => 1
        ]);
    }
}
