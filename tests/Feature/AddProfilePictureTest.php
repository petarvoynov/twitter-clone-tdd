<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddProfilePictureTest extends TestCase
{
    /** @test */
    function guests_cannot_add_a_profile_picture()
    {
        $this->post('/users/1/profile-picture', [])
            ->assertRedirect('login');
    }
}
