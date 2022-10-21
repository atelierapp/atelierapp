<?php

namespace Tests\Feature\Product;

use App\Enums\ManufacturerProcessEnum;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Quality;
use App\Models\Store;
use JMac\Testing\Traits\AdditionalAssertions;

/**
 * @title Products
 * @group products
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerUpdateTest extends BaseTest
{
    use AdditionalAssertions;

    public function test_a_guess_cannot_update_any_product()
    {
        $response = $this->patchJson(route('product.update', 1), []);

        $response->assertUnauthorized();
    }

    public function test_update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'update',
            \App\Http\Requests\ProductUpdateRequest::class
        );
    }

    public function test_authenticated_seller_cannot_update_a_product_without_any_required_param()
    {
        $this->createAuthenticatedSeller();
        $product = Product::factory()->create();

        $response = $this->patchJson(route('product.update', $product->id), [], $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'title',
            'qualities',
            'manufacturer_process',
            'category_id',
            'description',
            'tags',
            'materials',
            'price',
        ]);
    }

    public function test_authenticated_seller_cannot_update_a_product_with_invalid_params()
    {
        $this->createAuthenticatedSeller();
        $product = Product::factory()->create();

        $data = [
            'title' => $this->faker->name,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),

            'store_id' => 'invalid_param',
            'category_id' => 'invalid_param',
            'manufacturer_type' => 'invalid_param',
            'manufacturer_process' => 'invalid_param',
        ];
        $response = $this->patchJson(route('product.update', $product->id), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'store_id',
            'category_id',
            'qualities',
            'manufacturer_process',
        ]);
    }

    public function test_authenticated_seller_can_update_a_product_with_only_required_info()
    {
        $this->createAuthenticatedSeller();
        $store = $this->createStore($this->createAuthenticatedSeller());
        $product = $this->createProduct($store);

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
            ],
            'materials' => [
                ['name' => $this->faker->unique()->name],
                ['name' => $this->faker->unique()->name],
                ['name' => $this->faker->unique()->name],
                ['name' => $this->faker->unique()->name],
                ['name' => $this->faker->unique()->name],
            ],
        ];
        $response = $this->patchJson(route('product.update', $product->id), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $response->assertJsonStructure(
            [
                'data' => [
                    'tags' => [
                        0 => [
                            'id',
                            'name',
                            'active',
                        ],
                    ],
                    'materials' => [
                        0 => [
                            'id',
                            'name',
                            'active',
                        ],
                    ],
                    'categories' => [
                        0 => [
                            'id',
                            'name',
                            'image',
                        ],
                    ],
                ],
            ]
        );
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => $data['title'],
            'manufacturer_process' => $data['manufacturer_process'],
        ]);
        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $data['category_id'],
        ]);
        $this->assertDatabaseCount('tags', 3);
        $this->assertDatabaseCount('taggables', 3);
        $this->assertDatabaseCount('materials', 5);
        $this->assertDatabaseCount('material_product', 5);
        $this->assertDatabaseCount('qualityables', 2);
    }

    public function test_authenticated_seller_can_update_a_product_with_required_info_and_collections()
    {
        $this->createAuthenticatedSeller();
        $store = $this->createStore($this->createAuthenticatedSeller());
        $product = $this->createProduct($store);
        Collection::factory()->count(3)->create();

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
            ],
            'materials' => [
                ['name' => $this->faker->unique()->name],
                ['name' => $this->faker->unique()->name],
                ['name' => $this->faker->unique()->name],
                ['name' => $this->faker->unique()->name],
                ['name' => $this->faker->unique()->name],
            ],

            'collections' => [
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
            ],
        ];
        $response = $this->patchJson(route('product.update', $product->id), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $response->assertJsonStructure(
            [
                'data' => [
                    'tags' => [
                        0 => [
                            'id',
                            'name',
                            'active',
                        ],
                    ],
                    'materials' => [
                        0 => [
                            'id',
                            'name',
                            'active',
                        ],
                    ],
                    'categories' => [
                        0 => [
                            'id',
                            'name',
                            'image',
                        ],
                    ],
                ],
            ]
        );
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseCount('category_product', 1);
        $this->assertEquals(3, Collection::authUser()->count());
        $this->assertDatabaseCount('collectionables', 3);
        $this->assertDatabaseCount('qualityables', 2);
    }

    public function test_authenticated_seller_cannot_update_a_product_that_has_a_store_and_that_not_him()
    {
        $store = $this->createStore($this->createAuthenticatedSeller());
        $product = $this->createProduct($store);

        $data = [
            'store_id' => Store::factory()->create()->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ],
            'materials' => [
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
            ],
        ];
        $response = $this->patchJson(route('product.update', $product->id), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'store_id',
        ]);
    }

    public function test_authenticated_seller_can_update_a_product_with_required_info_more_is_on_demand_more_is_unique_param()
    {
        $this->createAuthenticatedSeller();
        $store = $this->createStore($this->createAuthenticatedSeller());
        $product = $this->createProduct($store);
        Collection::factory()->count(3)->create();

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ],
            'materials' => [
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
            ],
            'is_on_demand' => $this->faker->boolean,
            'is_unique' => $this->faker->boolean,
        ];
        $response = $this->patchJson(route('product.update', $product->id), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $response->assertJsonStructure(
            [
                'data' => [
                    'tags' => [
                        0 => [
                            'id',
                            'name',
                            'active',
                        ],
                    ],
                    'materials' => [
                        0 => [
                            'id',
                            'name',
                            'active',
                        ],
                    ],
                    'categories' => [
                        0 => [
                            'id',
                            'name',
                            'image',
                        ],
                    ],
                ],
            ]
        );
        $this->assertEquals($data['is_on_demand'], $response->json('data.is_on_demand'));
        $this->assertEquals($data['is_unique'], $response->json('data.is_unique'));
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('qualityables', 2);
    }
}
