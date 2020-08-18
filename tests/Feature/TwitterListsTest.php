<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\TwitterList;

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

    /** @test */
    function a_list_can_be_created_with_an_cover_image()
    {
        // Given we are sign in and have prepared a list with an image
        $user = $this->signIn();

        Storage::fake('public');

        $list = factory('App\TwitterList')->make(['cover_image' => $cover_image = UploadedFile::fake()->image('cover_image.jpg')]);

        // When we hit the route to create the list
        $this->post('/lists', $list->toArray());

        $list = TwitterList::first();

        // Then there should be a record in the database
        $this->assertEquals('cover_images/' . $cover_image->hashName(), $list->cover_image);

        Storage::disk('public')->assertExists('cover_images/' . $cover_image->hashName());

        $this->assertDatabaseHas('twitter_lists', [
            'cover_image' => 'cover_images/'. $cover_image->hashName()
        ]);
    }

    /** @test */
    function a_user_can_view_his_single_list()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in and have a lists
        $user = $this->signIn();

        $list = factory('App\TwitterList')->create(['user_id' => $user->id]);

        // When we hit the route to see the list
        $response = $this->get('/lists/'. $list->id);

        // Then we should see the list
        $response->assertSee($list->name, $list->description);
    }

    /** @test */
    function only_auth_users_can_create_lists()
    {
        $this->get('/lists/create')->assertRedirect('login');

        $this->post('/lists', [])->assertRedirect('login');
    }

    /** @test */
    function the_creator_of_the_twitter_list_can_add_users_to_it()
    {
        // Given we are sing in and have a list
        $user = $this->signIn();

        $userToAdd = factory('App\User')->create();

        $list = factory('App\TwitterList')->create(['user_id' => $user->id]);
  
        // When we hit the route to add users to that list
        $this->post("/lists/{$list->id}/users", [
            'user_id' => $userToAdd->id
        ]);

        // Then there should be record/records in the database
        $this->assertDatabaseHas('list_users', [
            'list_id' => $list->id,
            'user_id' => $userToAdd->id
        ]);
    }

    /** @test */
    function user_cannot_add_users_to_a_list_that_doesnt_belongs_to_them()
    {
       // Given we are sing in and there is a list that doesn't belongs to us
       $user = $this->signIn();

       $creatorOfTheList = factory('App\User')->create();

       $userToAdd = factory('App\User')->create();

       $list = factory('App\TwitterList')->create(['user_id' => $creatorOfTheList->id]);
 
       // When we hit the route to add users to that list
       $response = $this->post("/lists/{$list->id}/users", [
           'user_id' => $userToAdd->id
       ]);

       // Then there should be a 403 response
       $response->assertStatus(403);

       // And there shouldn't be record/records in the database
       $this->assertDatabaseMissing('list_users', [
           'list_id' => $list->id,
           'user_id' => $userToAdd->id
       ]);
    }

    /** @test */
    function the_owner_of_the_list_can_remove_users_that_are_already_added_to_the_list()
    {
        $this->withoutExceptionHandling();
        // Given we are sing in and have a list with a user in it
        $user = $this->signIn();

        $list = factory('App\TwitterList')->create(['user_id' => $user->id]);

        $userToRemoveFromTheList = factory('App\User')->create();

        $user->follow($userToRemoveFromTheList);

        $this->post("/lists/{$list->id}/users", [
            'user_id' => $userToRemoveFromTheList->id
        ]);

        // When we hit the route to remove that user form the list
        $this->delete("/lists/{$list->id}/users", [
            'user_id' => $userToRemoveFromTheList->id
        ]);

        // Then there should not be a record for this user in the database
        $this->assertDatabaseMissing('list_users', [
            'user_id' => $userToRemoveFromTheList->id,
            'list_id' => $list->id
        ]);
    }
}
