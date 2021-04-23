<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Media;
use App\Models\MediaType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MediaController
 */
class MediaControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        Media::factory()->count(3)->create();

        $response = $this->getJson(route('media.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MediaController::class,
            'store',
            \App\Http\Requests\MediaStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $data = [
            'type_id' => MediaType::factory()->create()->id,
            'url' => $this->faker->url,
            'main' => $this->faker->boolean,
        ];

        $response = $this->postJson(route('media.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas('media', $data);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $media = Media::factory()->create();

        $response = $this->get(route('media.show', $media));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MediaController::class,
            'update',
            \App\Http\Requests\MediaUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $media = Media::factory()->create();

        $data = [
            'type_id' => MediaType::factory()->create()->id,
            'url' => $this->faker->url,
            'main' => $this->faker->boolean,
        ];

        $response = $this->put(route('media.update', $media), $data);
        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas('media', array_merge(['id' => $media->id], $data));
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $media = Media::factory()->create();

        $response = $this->delete(route('media.destroy', $media));

        $response->assertNoContent();

        $this->assertDeleted($media);
    }
}
