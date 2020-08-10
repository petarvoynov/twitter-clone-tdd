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

    /** @test */
    function a_list_requires_a_name()
    {
        // Given we are sign in and have prepared a list
        $user = $this->signIn();

        $list = factory('App\TwitterList')->make(['name' => '']);

        // When we try to create it without a name
        $response = $this->post('/lists', $list->toArray());

        // Then there should be an error that the name is required
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    function a_lists_cover_image_filed_accepts_only_image_files()
    {
        // Given we are sign in and have prepared a list with non image
        $user = $this->signIn();

        $list = factory('App\TwitterList')->make(['cover_image' => 'no-image']);

        // When we try to create it with that non-image
        $response = $this->post('/lists', $list->toArray());

        // Then there should be an error that the cover_image field should contain only image files
        $response->assertSessionHasErrors('cover_image');

    }
}
