<?php

namespace Tests\Feature\Product;

use App\Enums\ManufacturerProcessEnum;
use App\Enums\ManufacturerTypeEnum;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Media;
use App\Models\Store;
use Database\Seeders\CategorySeeder;
use Illuminate\Http\UploadedFile;
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

    public function test_authenticated_seller_can_store_a_product_with_tags(): void
    {
        $this->createAuthenticatedSeller();
        $store = Store::factory()->create();

        $data = [
            'store_id' => $store->id,

            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ]
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
                    'tags' => [
                        0 => [
                            'id',
                            'name'
                        ]
                    ]
                ],
            ]
        );
        $this->assertDatabaseHas(
            'products',
            collect($data)->except([
                'properties', 'manufactured_at', 'category_id', 'tags'
            ])->toArray()
        );
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('tags', 3);
        $this->assertDatabaseCount('taggables', 3);
    }

    public function test_authenticated_seller_can_store_a_product_with_collections(): void
    {
        $this->createAuthenticatedSeller();
        $store = Store::factory()->create();

        $data = [
            'store_id' => $store->id,

            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'collections' => [
                ['id' => Collection::factory()->create()->id],
            ]

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
                    'collections' => [
                        0 => [
                            'id',
                            'name'
                        ]
                    ]
                ],
            ]
        );
        $this->assertDatabaseHas(
            'products',
            collect($data)->except([
                'properties', 'manufactured_at', 'category_id', 'collections'
            ])->toArray()
        );
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('collections', 1);
        $this->assertDatabaseCount('collectionables', 1);
    }

    public function test_authenticated_seller_can_store_a_product_with_front_images(): void
    {
        Storage::fake('s3');
        $this->createAuthenticatedSeller();
        $store = Store::factory()->create();

        $data = [
            'store_id' => $store->id,

            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
            ]
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
                    'medias' => [
                        0 => [
                            'type_id',
                            'url',
                            'orientation',
                        ]
                    ]
                ],
            ]
        );
        $this->assertDatabaseHas(
            'products',
            collect($data)->except([
                'properties', 'manufactured_at', 'category_id', 'images'
            ])->toArray()
        );
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('media', 1);
        $this->assertDatabaseHas('media', ['featured' => true]);
    }

    public function test_authenticated_seller_can_store_a_product_with_side_images(): void
    {
        Storage::fake('s3');
        $this->createAuthenticatedSeller();
        $store = Store::factory()->create();

        $data = [
            'store_id' => $store->id,

            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'images' => [
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
            ]
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
                    'medias' => [
                        0 => [
                            'type_id',
                            'url',
                            'orientation',
                        ]
                    ]
                ],
            ]
        );
        $this->assertDatabaseHas(
            'products',
            collect($data)->except([
                'properties', 'manufactured_at', 'category_id', 'images'
            ])->toArray()
        );
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('media', 1);
        $this->assertDatabaseHas('media', ['orientation' => 'side', 'featured' => false]);
    }

    public function test_authenticated_seller_can_store_a_product_with_perspective_images(): void
    {
        Storage::fake('s3');
        $this->createAuthenticatedSeller();
        $store = Store::factory()->create();

        $data = [
            'store_id' => $store->id,

            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'images' => [
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
            ]
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
                    'medias' => [
                        0 => [
                            'type_id',
                            'url',
                            'orientation',
                        ]
                    ]
                ],
            ]
        );
        $this->assertDatabaseHas(
            'products',
            collect($data)->except([
                'properties', 'manufactured_at', 'category_id', 'images'
            ])->toArray()
        );
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('media', 1);
        $this->assertDatabaseHas('media', ['orientation' => 'perspective', 'featured' => false]);
    }

    public function test_authenticated_seller_can_store_a_product_with_plan_images(): void
    {
        Storage::fake('s3');
        $this->createAuthenticatedSeller();
        $store = Store::factory()->create();

        $data = [
            'store_id' => $store->id,

            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'images' => [
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ]

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
                    'medias' => [
                        0 => [
                            'type_id',
                            'url',
                            'orientation',
                        ]
                    ]
                ],
            ]
        );
        $this->assertDatabaseHas(
            'products',
            collect($data)->except([
                'properties', 'manufactured_at', 'category_id', 'images'
            ])->toArray()
        );
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('media', 1);
        $this->assertDatabaseHas('media', ['orientation' => 'plan', 'featured' => false]);
    }

    public function test_authenticated_seller_can_store_a_product_with_all_images(): void
    {
        Storage::fake('s3');
        $this->createAuthenticatedSeller();
        $store = Store::factory()->create();

        $data = [
            'store_id' => $store->id,

            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ]

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
                    'medias' => [
                        0 => [
                            'type_id',
                            'url',
                            'orientation',
                        ]
                    ]
                ],
            ]
        );
        $this->assertDatabaseHas(
            'products',
            collect($data)->except([
                'properties', 'manufactured_at', 'category_id', 'images'
            ])->toArray()
        );
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('media', 4);
        $this->assertEquals(1, Media::where('featured', true)->count());
        $this->assertEquals(3, Media::where('featured', false)->count());
    }
}
