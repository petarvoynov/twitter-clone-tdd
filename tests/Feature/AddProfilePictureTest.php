<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        // Given we are sing in
        $user = $this->signIn();

        // When we hit the route to upload an profile picture with an invalid data
        $response = $this->post('/users/' . $user->id. '/profile-picture',[
            'profile_picture' => 'not_an_image'
        ]);

        // Then there should be and error 
        $response->assertSessionHasErrors('profile_picture');
    }

    /** @test */
    function an_authenticated_user_can_add_a_profile_picture()
    {
        // Given we are sign in
        $user = $this->signIn();

        // When we hit the route to upload an profile picture with valid data
        Storage::fake('public');

        $response = $this->post('/users/' . $user->id. '/profile-picture',[
            'profile_picture' => $file = UploadedFile::fake()->image('profile_picture.jpg')
        ]);

        // Then there should be a record in the database
        $this->assertEquals('profile_pictures/'. $file->hashName(), $user->profile_picture);

        Storage::disk('public')->assertExists('profile_pictures/' . $file->hashName());
    }
}
