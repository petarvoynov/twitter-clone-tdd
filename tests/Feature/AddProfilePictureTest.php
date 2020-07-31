<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddProfilePictureTest extends TestCase
{
    /** @test */
    function only_authenticated_users_can_add_profile_picture()
    {
        $this->post('/users/1/profile-picture', [])
            ->assertRedirect('login');
    }
}
