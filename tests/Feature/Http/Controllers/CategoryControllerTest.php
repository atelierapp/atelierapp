<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @title Categories
 * @see \App\Http\Controllers\CategoryController
 */
class CategoryControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     * @title List categories
     */
    public function index_behaves_as_expected(): void
    {
        Category::factory()->count(3)->create();

        $response = $this->get(route('category.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'name',
                    'image',
                    'parent_id',
                    'active',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CategoryController::class,
            'store',
            \App\Http\Requests\CategoryStoreRequest::class
        );
    }

    /**
     * @test
     * @title Create category
     */
    public function store_saves(): void
    {
        $data = [
            'name' => $this->faker->name,
            'image' => UploadedFile::fake()->image('category.jpg'),
            'active' => $this->faker->boolean,
        ];

        $response = $this->postJson(route('category.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'image',
                'parent_id',
                'active',
                'created_at',
                'updated_at',
            ]
        ]);

        $this->assertDatabaseHas('categories', collect($data)->except(['image'])->toArray());
    }


    /**
     * @test
     * @title Show category
     */
    public function show_behaves_as_expected(): void
    {
        $category = Category::factory()->create();

        $response = $this->getJson(route('category.show', $category));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'image',
                'parent_id',
                'active',
                'created_at',
                'updated_at',
            ]
        ]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CategoryController::class,
            'update',
            \App\Http\Requests\CategoryUpdateRequest::class
        );
    }

    /**
     * @test
     * @title Update category
     */
    public function update_behaves_as_expected(): void
    {
        $category = Category::factory()->create();
        $data = [
            'name' => $this->faker->name,
            'image' => UploadedFile::fake()->image('category.jpg'),
            'active' => $this->faker->boolean,
        ];

        $response = $this->putJson(route('category.update', $category), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'image',
                'parent_id',
                'active',
                'created_at',
                'updated_at',
            ]
        ]);

        $params = collect($data)->except(['image'])->toArray();
        $params['id'] = $category->id;
        $this->assertDatabaseHas('categories', $params);
    }


    /**
     * @test
     * @title Delete category
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $category = Category::factory()->create();

        $response = $this->delete(route('category.destroy', $category));

        $response->assertNoContent();

        $this->assertSoftDeleted($category);
    }
}
