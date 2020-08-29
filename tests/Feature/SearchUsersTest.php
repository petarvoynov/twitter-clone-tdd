<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function the_search_input_returns_users_result()
    {
        // Given we are sign and there are users to search
        $user = $this->signIn();

        $userToFindOne = factory('App\User')->create(['name' => 'To find Joe']);
        $userToFindTwo = factory('App\User')->create(['name' => 'To find Jack']);
        $userToFindThree = factory('App\User')->create(['name' => 'To find Jane']);

        $userToMissOne = factory('App\User')->create(['name' => 'Marry']);
        $userToMissTwo = factory('App\User')->create(['name' => 'Molly']);
        $userToMissThree = factory('App\User')->create(['name' => 'Mercy']);

        // When we hit the route to search for users
        $response = $this->post('/users/find', ['name' => 'find']);

        // The we should get the users names that contain our search without our profile
        $response->assertSee($userToFindOne->name,$userToFindTwo->name,$userToFindThree->name);
        $response->assertDontSee($userToMissOne->name, $userToMissTwo->name, $userToMissThree->name);
    }
}
