<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        factory(Category::class, 25)->create();

        $response = $this->getJson(route('categories.index'));

        $response->assertOk();
        $this->assertCount(10, $response->json()['data']);
    }

    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CategoryController::class,
            'store',
            \App\Http\Requests\CategoryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $this->withExceptionHandling();
        $name = $this->faker->word;

        $response = $this->post(route('categories.store'), [
            'name' => $name,
        ]);

        $categories = Category::query()->get();
        $this->assertCount(1, $categories);

        $category = $categories->first();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $name,
        ]);
    }

    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $category = factory(Category::class)->create();

        $response = $this->get(route('categories.show', ['category' => $category->id]));

        $response->assertOk();
        $this->assertEquals($category->id, $response->json()['data']['id']);
    }

    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CategoryController::class,
            'update',
            \App\Http\Requests\CategoryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $category = factory(Category::class)->create();
        $newName = $this->faker->word;

        $response = $this->put(route('categories.update', [
            'category' => $category->id,
        ]), ['name' => $newName]);

        $response->assertOk();
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $newName,
        ]);
    }

    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $category = factory(Category::class)->create();

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertOk();

        $this->assertSoftDeleted($category);
    }
}
