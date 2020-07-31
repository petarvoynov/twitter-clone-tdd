<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddProfilePictureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_cannot_add_a_profile_picture()
    {
        $this->post('/users/1/profile-picture', []) 
            ->assertRedirect('login');
    }

    /** @test */
    function a_valid_profile_picture_must_be_provided()
    {
        $user = $this->signIn();

        $response = $this->post('/users/' . $user->id. '/profile-picture',[
            'profile_picture' => 'not_an_image'
        ]);

        $response->assertSessionHasErrors('profile_picture');
    }
}
