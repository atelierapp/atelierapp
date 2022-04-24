<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @title Stores
 * @see \App\Http\Controllers\StoreController
 */
class StoreControllerImageTest extends TestCase
{
    use AdditionalAssertions;
    use WithFaker;

    public function test_a_guess_user_cannot_upload_any_image_to_store()
    {
        $response = $this->postJson(route('store.image', 1));

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_upload_any_image_to_store()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('store.image', 1));

        $response->assertStatus(403);
    }

    public function test_image_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StoreController::class,
            'image',
            \App\Http\Requests\StoreImageRequest::class
        );
    }

    public function test_a_authenticated_seller_user_can_upload_a_logo_image_to_his_store()
    {
        Storage::fake('s3');
        $store = Store::factory()->create();
        $this->createAuthenticatedSeller();

        $data = [
            'logo' => UploadedFile::fake()->image('logo.png'),
        ];
        $response = $this->postJson(route('store.image', $store->id), $data);

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertDatabaseHas('media', [
            'mediable_type' => Store::class,
            'orientation' => 'logo',
        ]);
    }

    private function structure(): array
    {
        return [
            'id',
            'name',
            // 'legal_name',
            // 'legal_id',
            'story',
            'logo',
            'cover',
            'team',
            'active',
        ];
    }

    public function test_a_authenticated_seller_user_can_upload_a_team_image_to_his_store()
    {
        Storage::fake('s3');
        $store = Store::factory()->create();
        $this->createAuthenticatedSeller();

        $data = [
            'team' => UploadedFile::fake()->image('team.png'),
        ];
        $response = $this->postJson(route('store.image', $store->id), $data);

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertDatabaseHas('media', [
            'mediable_type' => Store::class,
            'orientation' => 'team',
        ]);
    }

    public function test_a_authenticated_seller_user_can_upload_all_images_to_his_store()
    {
        Storage::fake('s3');
        $store = Store::factory()->create();
        $this->createAuthenticatedSeller();

        $data = [
            'logo' => UploadedFile::fake()->image('logo.png'),
            'team' => UploadedFile::fake()->image('team.png'),
            'cover' => UploadedFile::fake()->image('cover.png'),
        ];
        $response = $this->postJson(route('store.image', $store->id), $data);

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertDatabaseCount('media', 3);
    }

}
