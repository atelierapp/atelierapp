<?php

namespace Tests\Feature\Collection;

use App\Models\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

class CollectionControllerImageTest extends TestCase
{
    use AdditionalAssertions;

    public function test_a_guess_cannot_upload_any_image_to_any_collection()
    {
        $response = $this->postJson(route('collection.image', 1), [], $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_upload_any_image_to_any_collection()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('collection.image', 1), [], $this->customHeaders());

        $response->assertStatus(403);
    }

    public function test_image_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CollectionController::class,
            'image',
            \App\Http\Requests\CollectionImageRequest::class
        );
    }

    public function test_an_authenticated_seller_can_upload_a_image_to_his_collection()
    {
        Storage::fake('s3');
        $user = $this->createAuthenticatedSeller();
        $collection = Collection::factory(['user_id' => $user->id])->pe()->create();

        $data = [
            'image' => UploadedFile::fake()->image('image.png'),
        ];
        $response = $this->postJson(route('collection.image', $collection->id), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'image',
                'is_active',
            ],
        ]);
        $this->assertNotNull($response->json('data.image'));
        $this->assertDatabaseCount('media', 1);
    }

    public function test_an_authenticated_seller_cannot_upload_a_image_to_collection_is_not_him()
    {
        Storage::fake('s3');
        $user = $this->createAuthenticatedSeller();
        $collection = Collection::factory()->create();

        $data = [
            'image' => UploadedFile::fake()->image('image.png'),
        ];
        $response = $this->postJson(route('collection.image', $collection->id), $data, $this->customHeaders());

        $response->assertNotFound();
    }
}
