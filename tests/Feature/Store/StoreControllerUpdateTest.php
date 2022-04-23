<?php

namespace Tests\Feature\Store;

use App\Models\Quality;
use App\Models\Store;
use Database\Seeders\QualitySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @title Stores
 * @see \App\Http\Controllers\StoreController
 */
class StoreControllerUpdateTest extends TestCase
{
    use AdditionalAssertions;
    use WithFaker;

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

    public function test_a_guess_user_cannot_update_any_store()
    {
        $response = $this->patchJson(route('store.update', 1));

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_create_any_store()
    {
        $this->createAuthenticatedUser();

        $response = $this->patchJson(route('store.update', 1));

        $response->assertStatus(403);
    }

    public function test_store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StoreController::class,
            'update',
            \App\Http\Requests\StoreUpdateRequest::class
        );
    }

    public function test_a_authenticated_seller_user_can_update_a_store_without_logo_image()
    {
        $store = Store::factory()->create();
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
        ];
        $response = $this->patchJson(route('store.update', $store->id), $data);

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'name' => $data['name'],
            'story' => $data['story'],
        ]);
    }

    public function test_a_authenticated_seller_user_can_update_a_store_with_logo_image()
    {
        Storage::fake('s3');
        $store = Store::factory()->create();
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'logo' => UploadedFile::fake()->image('logo.png'),
        ];
        $response = $this->patchJson(route('store.update', $store->id), $data);

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertEquals($data['name'], $response->json('data.name'));
        $this->assertEquals($data['story'], $response->json('data.story'));
        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'name' => $data['name'],
            'story' => $data['story'],
        ]);
        $this->assertDatabaseCount('media', 1);
        $this->assertCount(1, Storage::disk('s3')->allFiles('stores'));
    }

    public function test_a_authenticated_seller_user_can_update_a_store_with_cover_image()
    {
        Storage::fake('s3');
        $store = Store::factory()->create();
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'cover' => UploadedFile::fake()->image('cover.png'),
        ];
        $response = $this->patchJson(route('store.update', $store->id), $data);

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertEquals($data['name'], $response->json('data.name'));
        $this->assertEquals($data['story'], $response->json('data.story'));
        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'name' => $data['name'],
            'story' => $data['story'],
        ]);
        $this->assertDatabaseCount('media', 1);
        $this->assertCount(1, Storage::disk('s3')->allFiles('stores'));
    }

    public function test_a_authenticated_seller_user_can_update_a_store_with_team_image()
    {
        Storage::fake('s3');
        $store = Store::factory()->create();
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'team' => UploadedFile::fake()->image('team.png'),
        ];
        $response = $this->patchJson(route('store.update', $store->id), $data);

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertEquals($data['name'], $response->json('data.name'));
        $this->assertEquals($data['story'], $response->json('data.story'));
        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'name' => $data['name'],
            'story' => $data['story'],
        ]);
        $this->assertDatabaseCount('media', 1);
        $this->assertCount(1, Storage::disk('s3')->allFiles('stores'));
    }

    public function test_a_authenticated_seller_user_can_update_store_with_logo_and_qualities()
    {
        Storage::fake('s3');
        $store = Store::factory()->create();
        $this->seed(QualitySeeder::class);
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'story' => $this->faker->sentences(1, true),
            'logo' => UploadedFile::fake()->image('logo.png'),
            'cover' => UploadedFile::fake()->image('cover.png'),
            'team' => UploadedFile::fake()->image('team.png'),
            'qualities' => Quality::query()->inRandomOrder()->limit(2)->get()->pluck('id')->toArray(),
        ];
        $response = $this->patchJson(route('store.update', $store->id), $data);

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertEquals($data['name'], $response->json('data.name'));
        $this->assertEquals($data['story'], $response->json('data.story'));
        $this->assertDatabaseHas('stores', [
            'name' => $data['name'],
            'story' => $data['story'],
        ]);
        $this->assertDatabaseCount('media', 3);
        $this->assertCount(3, Storage::disk('s3')->allFiles('stores'));
        $this->assertDatabaseCount('qualityables', 2);
    }

}
