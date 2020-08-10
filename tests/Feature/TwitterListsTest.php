<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TwitterListsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_view_his_lists()
    {
        $this->withoutExceptionHandling();
        // Given we are sign in and have two lists
        $user = $this->signIn();

        $lists = factory('App\TwitterList', 2)->create(['user_id' => $user->id]);

        // When we hit the route to see our lists
        $response = $this->get('/lists');

        // Then we should see the lists
        $response->assertSee($lists[0]->name, $lists[1]->name);
    }

    /** @test */
    function a_list_can_be_created()
    {
        // Given we are sing in and prepared a lists to create
        $user = $this->signIn();

        $list = factory('App\TwitterList')->make(['user_id' => $user->id]);
        // When we hit the route to create a list
        $this->post('/lists', $list->toArray());

        // Then the lists should be in the database
        $this->assertDatabaseHas('twitter_lists', $list->toArray());
    }
}
