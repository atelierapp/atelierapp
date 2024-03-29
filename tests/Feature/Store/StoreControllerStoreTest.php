<?php

namespace Tests\Feature\Store;

use App\Models\Quality;
use Database\Seeders\QualitySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;

/**
 * @title Stores
 * @group stores
 * @see \App\Http\Controllers\StoreController
 */
class StoreControllerStoreTest extends BaseTest
{
    use AdditionalAssertions;
    use WithFaker;

    public function test_a_guess_user_cannot_create_any_store()
    {
        $response = $this->postJson(route('store.store'));

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_create_any_store()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('store.store'), [], $this->customHeaders());

        $response->assertStatus(403);
    }

    public function test_store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StoreController::class,
            'store',
            \App\Http\Requests\StoreStoreRequest::class
        );
    }

    public function test_a_authenticated_seller_user_cannot_create_store_without_logo_image()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
        ];
        $response = $this->postJson(route('store.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['logo']);
        $this->assertEquals('The logo image is required.', $response->json('errors.logo.0'));
    }

    public function test_a_authenticated_seller_user_cannot_create_store_with_invalid_logo_image()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'logo' => $this->faker->word,
        ];
        $response = $this->postJson(route('store.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['logo']);
        $this->assertEquals('The logo must be an image.', $response->json('errors.logo.0'));
    }

    public function test_a_authenticated_seller_user_can_create_store_with_logo_image()
    {
        Storage::fake('s3');
        $user = $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'logo' => UploadedFile::fake()->image('logo.png'),
        ];
        $response = $this->postJson(route('store.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertEquals($data['name'], $response->json('data.name'));
        $this->assertEquals($data['story'], $response->json('data.story'));
        $this->assertDatabaseHas('stores', [
            'user_id' => $user->id,
            'name' => $data['name'],
            'story' => $data['story'],
        ]);
        $this->assertDatabaseCount('media', 1);
        $this->assertCount(1, Storage::disk('s3')->allFiles('stores'));
    }

    public function test_a_authenticated_seller_user_can_create_store_with_logo_image_and_has_authenticated_user_id()
    {
        Storage::fake('s3');
        $user = $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'logo' => UploadedFile::fake()->image('logo.png'),
        ];
        $response = $this->postJson(route('store.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertEquals($data['name'], $response->json('data.name'));
        $this->assertEquals($data['story'], $response->json('data.story'));
        $this->assertDatabaseHas('stores', [
            'user_id' => $user->id,
            'name' => $data['name'],
            'story' => $data['story'],
        ]);
        $this->assertDatabaseCount('media', 1);
        $this->assertCount(1, Storage::disk('s3')->allFiles('stores'));
    }

    public function test_a_authenticated_seller_user_cannot_create_store_with_logo_and_invalid_cover_image()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'logo' => UploadedFile::fake()->image('logo.png'),
            'cover' => $this->faker->name,
        ];
        $response = $this->postJson(route('store.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['cover']);
        $this->assertEquals('The cover must be an image.', $response->json('errors.cover.0'));
    }

    public function test_a_authenticated_seller_user_can_create_store_with_logo_and_cover_image()
    {
        Storage::fake('s3');
        $user = $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'logo' => UploadedFile::fake()->image('logo.png'),
            'cover' => UploadedFile::fake()->image('cover.png'),
        ];
        $response = $this->postJson(route('store.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertEquals($data['name'], $response->json('data.name'));
        $this->assertEquals($data['story'], $response->json('data.story'));
        $this->assertDatabaseHas('stores', [
            'user_id' => $user->id,
            'name' => $data['name'],
            'story' => $data['story'],
        ]);
        $this->assertDatabaseCount('media', 2);
        $this->assertCount(2, Storage::disk('s3')->allFiles('stores'));
    }

    public function test_a_authenticated_seller_user_cannot_create_store_with_logo_cover_and_invalid_team_image()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'logo' => UploadedFile::fake()->image('logo.png'),
            'cover' => UploadedFile::fake()->image('cover.png'),
            'team' => $this->faker->name,
        ];
        $response = $this->postJson(route('store.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['team']);
        $this->assertEquals('The team must be an image.', $response->json('errors.team.0'));
    }

    public function test_a_authenticated_seller_user_can_create_store_with_logo_cover_and_team_image()
    {
        Storage::fake('s3');
        $this->createAuthenticatedSeller();
        $user = $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'logo' => UploadedFile::fake()->image('logo.png'),
            'cover' => UploadedFile::fake()->image('cover.png'),
            'team' => UploadedFile::fake()->image('team.png'),
        ];
        $response = $this->postJson(route('store.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertEquals($data['name'], $response->json('data.name'));
        $this->assertEquals($data['story'], $response->json('data.story'));
        $this->assertDatabaseHas('stores', [
            'user_id' => $user->id,
            'name' => $data['name'],
            'story' => $data['story'],
        ]);
        $this->assertDatabaseCount('media', 3);
        $this->assertCount(3, Storage::disk('s3')->allFiles('stores'));
    }

    public function test_a_authenticated_seller_user_can_create_store_with_logo_and_qualities()
    {
        Storage::fake('s3');
        $this->seed(QualitySeeder::class);
        $this->createAuthenticatedSeller();
        $user = $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'logo' => UploadedFile::fake()->image('logo.png'),
            'qualities' => Quality::query()->inRandomOrder()->limit(2)->get()->pluck('id')->toArray(),
        ];
        $response = $this->postJson(route('store.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertEquals($data['name'], $response->json('data.name'));
        $this->assertEquals($data['story'], $response->json('data.story'));
        $this->assertDatabaseHas('stores', [
            'user_id' => $user->id,
            'name' => $data['name'],
            'story' => $data['story'],
        ]);
        $this->assertDatabaseCount('media', 1);
        $this->assertCount(1, Storage::disk('s3')->allFiles('stores'));
        $this->assertDatabaseCount('qualityables', 2);
    }

}
