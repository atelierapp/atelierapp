<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        factory(Product::class)->times(50)->create();

        $response = $this->get(route('products.index'));

        $response->assertOk();
        $response->assertJsonCount(10, 'data');
    }

    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'store',
            \App\Http\Requests\ProductStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $category = factory(Category::class)->create();

        $data = [
            'store_id' => (factory(Store::class)->create())->id,
            'title' => $this->faker->sentence(4),
            'manufacturer_type' => 'store',
            'manufactured_at' => $this->faker->date('m/d/Y'),
            'description' => $this->faker->text,
            'category_id' => $category->id,
            'price' => $this->faker->randomNumber(),
            'quantity' => $this->faker->randomNumber(),
            'sku' => $this->faker->lexify('???????????'),
            'active' => $this->faker->boolean,
            'properties' => [
                'some' => 'value',
            ],
        ];;

        $response = $this->postJson(route('products.store'), $data);

        $response->assertCreated();
        $products = Product::all();
        $this->assertCount(1, $products);
    }

    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $product = factory(Product::class)->create();

        $response = $this->getJson(route('products.show', $product));

        $response->assertOk();
        $response->assertJsonFragment(['title' => $product->title]);
    }

    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'update',
            \App\Http\Requests\ProductUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $product = factory(Product::class)->create();
        $newTitle = $this->faker->word;

        $response = $this->putJson(route('products.update', $product), [
            'title' => $newTitle,
        ]);

        $response->assertOk();
        $response->assertJsonFragment(['title' => $newTitle]);
    }

    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $this->withoutExceptionHandling();
        $product = factory(Product::class)->create();

        $response = $this->deleteJson(route('products.destroy', $product));

        $response->assertOk();
        $this->assertSoftDeleted($product);
    }
}
