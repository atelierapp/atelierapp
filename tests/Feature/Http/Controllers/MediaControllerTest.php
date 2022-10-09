<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Media;
use App\Models\MediaType;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Storage;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MediaController
 */
class MediaControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    private function structure(): array
    {
        return [
            'id',
            'type_id',
            'url',
        ];
    }

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        Storage::fake('s3');
        Product::factory()->times(2)->create();
        Project::factory()->times(2)->create();
        Media::factory()->count(3)->create();

        $response = $this->getJson(route('media.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure()
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total',
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next'
            ]
        ]);
    }

    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        Storage::fake('s3');
        Product::factory()->times(2)->create();
        Project::factory()->times(2)->create();
        $media = Media::factory()->create();

        $response = $this->get(route('media.show', $media));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure()
        ]);
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
        Storage::fake('s3');
        Product::factory()->times(2)->create();
        Project::factory()->times(2)->create();
        $media = Media::factory()->create();
        $data = [
            'type_id' => MediaType::factory()->create()->id,
            'url' => $this->faker->url,
            'featured' => $this->faker->boolean,
        ];

        $response = $this->put(route('media.update', $media), $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure()
        ]);

        $this->assertDatabaseHas('media', array_merge(['id' => $media->id], $data));
    }

    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        Product::factory()->times(2)->create();
        Project::factory()->times(2)->create();
        $media = Media::factory()->create();

        $response = $this->deleteJson(route('media.destroy', $media));

        $response->assertNoContent();

        $this->assertDeleted($media);
    }
}
