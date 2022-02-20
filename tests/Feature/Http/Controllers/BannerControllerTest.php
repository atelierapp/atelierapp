<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Banner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BannerController
 */
class BannerControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    private function structure()
    {
        return [
            'title',
            'image_url',
            'order',
            'segment',
            'type',
        ];
    }

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        Banner::factory()->count(3)->create();

        $response = $this->get(route('banner.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure()
            ],
        ]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BannerController::class,
            'store',
            \App\Http\Requests\BannerStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        Storage::fake('s3');
        $data = [
            'name' => $this->faker->word,
            'order' => $this->faker->numberBetween(0, 50),
            'image' => UploadedFile::fake()->image('imagen.jpg'),
            'segment' => $this->faker->word,
            'type' => $this->faker->randomElement([Banner::TYPE_POPUP, Banner::TYPE_CAROUSEL]),
        ];

        $response = $this->postJson(route('banner.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure()
        ]);
        $this->assertEquals(1, count(Storage::disk('s3')->allFiles('banners')));
    }

    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $banner = Banner::factory()->create();

        $response = $this->get(route('banner.show', $banner));

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
            \App\Http\Controllers\BannerController::class,
            'update',
            \App\Http\Requests\BannerUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $banner = Banner::factory()->create();
        $data = [
            'name' => $this->faker->word,
            'order' => $this->faker->numberBetween(0, 50),
            'segment' => $this->faker->word,
            'type' => $this->faker->randomElement([Banner::TYPE_POPUP, Banner::TYPE_CAROUSEL]),
        ];

        $response = $this->putJson(route('banner.update', $banner), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure()
        ]);

        $this->assertDatabaseHas(
            'banners',
            [
                'name' => $data['name'],
                'order' => $data['order'],
                'segment' => $data['segment'],
                'type' => $data['type'],
            ]
        );
    }

    /**
     * @test
     * @title Create product
     */
    public function user_can_upload_a_image_to_exists_banner()
    {
        Storage::fake('s3');
        $project = Banner::factory()->create();

        $data = [
            'image' => UploadedFile::fake()->image('imagen.jpg'),
        ];
        $response = $this->postJson(route('banner.image', $project), $data);

        $response->assertOk();
        $this->assertEquals(1, count(Storage::disk('s3')->allFiles('banners')));
    }

    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $banner = Banner::factory()->create();

        $response = $this->delete(route('banner.destroy', $banner));

        $response->assertNoContent();

        $this->assertDatabaseMissing('banners', ['id' => $banner->id]);
    }
}
