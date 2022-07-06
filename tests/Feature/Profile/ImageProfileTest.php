<?php

namespace Profile;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use function route;

class ImageProfileTest extends TestCase
{
    public function test_a_guess_user_cannot_upload_any_image()
    {
        $response = $this->postJson(route('profile.image'));

        $response->assertStatus(401);
    }

    public function test_an_authenticated_seller_user_can_upload_a_image_to_his_profile()
    {
        $this->createAuthenticatedSeller();
        Storage::fake('s3');

        $data = [
            'avatar' => UploadedFile::fake()->image('avatar.png'),
        ];
        $response = $this->postJson(route('profile.image'), $data);

        $response->assertOk();
        $response->assertJsonStructure(['data' => [
            'id',
            'first_name',
            'last_name',
            'email',
            'phone',
            'birthday',
            'avatar',
            'is_active',
        ]]);
    }
}
