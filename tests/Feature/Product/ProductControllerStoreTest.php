<?php

namespace Tests\Feature\Product;

use App\Enums\ManufacturerProcessEnum;
use App\Enums\ManufacturerTypeEnum;
use App\Models\Category;
use App\Models\Store;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

class ProductControllerStoreTest extends TestCase
{
    use AdditionalAssertions;

    public function test_a_guess_cannot_create_any_product()
    {
        $response = $this->postJson(route('product.store'), []);

        $response->assertUnauthorized();
    }

    public function test_store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'store',
            \App\Http\Requests\ProductStoreRequest::class
        );
    }

    public function test_authenticated_seller_can_store_a_product_with_only_required_info(): void
    {
        Storage::fake('s3');
        $this->createAuthenticatedSeller();
        $store = Store::factory()->create();
        $this->seed(CategorySeeder::class);

        $data = [
            'store_id' => $store->id,

            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::inRandomOrder()->first()->id,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
        $response = $this->postJson(route('product.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'title',
                    'manufacturer_type',
                    'manufacturer_process',
                    'manufactured_at',
                    'description',
                    'price',
                    'style_id',
                    'style',
                    'quantity',
                    'sku',
                    'active',
                    'properties',
                    'url',
                ],
            ]
        );
        $this->assertDatabaseHas(
            'products',
            collect($data)->except(['properties', 'manufactured_at', 'category_id'])->toArray()
        );
        $this->assertDatabaseCount('category_product', 1);
    }

    public function wip_test_authenticated_seller_can_store_a_product_with_only_required_info(): void
    {
        Storage::fake('s3');
        $this->createAuthenticatedSeller();
        $store = Store::factory()->create();
        $this->seed(CategorySeeder::class);

        $data = [
            'store_id' => $store->id,

            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::inRandomOrder()->first()->id,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),

            // 'manufactured_at' => $this->faker->date('m/d/Y'),
            // 'sku' => $this->faker->word,
            // 'active' => true,
            // 'properties' => ['demo' => $this->faker->word],
            // 'style_id' => Style::factory()->create()->id,
            // 'url' => $this->faker->url,
        ];
        $response = $this->postJson(route('product.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'title',
                    'manufacturer_type',
                    'manufactured_at',
                    'description',
                    'price',
                    'style_id',
                    'style',
                    'quantity',
                    'sku',
                    'active',
                    'properties',
                    'url',
                ],
            ]
        );
        $this->assertDatabaseHas(
            'products',
            collect($data)->except(['properties', 'manufactured_at'])->toArray()
        );
    }
}
