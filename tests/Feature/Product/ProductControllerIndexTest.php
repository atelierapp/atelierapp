<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Collection;
use App\Models\FavoriteProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use JMac\Testing\Traits\AdditionalAssertions;

class ProductControllerIndexTest extends BaseTest
{
    use AdditionalAssertions;

    public function test_a_guess_can_list_products()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson(route('product.index'));

        $response->assertOk();
        $response->assertJsonStructure(['data' => [0 => $this->structure()]]);
    }

    public function test_authenticated_app_user_can_list_all_products()
    {
        $this->createAuthenticatedUser();
        Product::factory()->count(8)->create();

        $response = $this->getJson(route('product.index'));

        $response->assertOk();
        $response->assertJsonCount(8, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
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
                'next',
            ],
        ]);
    }

    public function test_authenticated_app_user_can_list_all_products_with_favorite()
    {
        $user = $this->createAuthenticatedUser();
        Product::factory()->count(8)->create();
        FavoriteProduct::query()->create(['user_id' => $user->id, 'product_id' => 2]);

        $response = $this->getJson(route('product.index'));

        $response->assertOk();
        $response->assertJsonCount(8, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'is_favorite'
                ]
            ]
        ]);
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
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
                'next',
            ],
        ]);
    }

    public function test_authenticated_app_user_can_list_products_filtered_by_search_param()
    {
        $this->createAuthenticatedUser();
        Product::factory()->count(6)->create();
        Product::factory(['title' => 'jaime'])->create();
        Product::factory(['title' => 'jaime'])->create();

        $response = $this->getJson(route('product.index', [
            'search' => 'jaime',
        ]));

        $response->assertOk();
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
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
                'next',
            ],
        ]);
    }

    public function test_authenticated_app_user_can_list_products_filtered_by_categories_param()
    {
        $this->createAuthenticatedUser();

        /** @var Category $category1 */
        $category1 = Category::factory()->create();
        $products = Product::factory()->times(4)->create(); // 2
        $category1->products()->attach($products);

        /** @var Category $category2 */
        $category2 = Category::factory()->create();
        $products = Product::factory()->times(3)->create(); // 3
        $category2->products()->attach($products);

        $response = $this->getJson(route('product.index', [
            'categories' => [
                $category1->id,
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(4, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
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
                'next',
            ],
        ]);
    }

    public function test_authenticated_admin_user_can_list_all_products()
    {
        $this->createAuthenticatedAdmin();
        Product::factory()->count(8)->create();

        $response = $this->getJson(route('product.index'));

        $response->assertOk();
        $response->assertJsonCount(8, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
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
                'next',
            ],
        ]);
    }

    public function test_authenticated_admin_user_can_list_products_filtered_by_search_param()
    {
        $this->createAuthenticatedUser();
        Product::factory()->count(6)->create();
        Product::factory(['title' => 'jaime'])->create();
        Product::factory(['title' => 'jaime'])->create();

        $response = $this->getJson(route('product.index', [
            'search' => 'jaime',
        ]));

        $response->assertOk();
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
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
                'next',
            ],
        ]);
    }

    public function test_authenticated_admin_user_can_list_products_filtered_by_categories_param()
    {
        $this->createAuthenticatedAdmin();

        /** @var Category $category1 */
        $category1 = Category::factory()->create();
        $products = Product::factory()->times(4)->create(); // 2
        $category1->products()->attach($products);

        /** @var Category $category2 */
        $category2 = Category::factory()->create();
        $products = Product::factory()->times(3)->create(); // 3
        $category2->products()->attach($products);

        $response = $this->getJson(route('product.index', [
            'categories' => [
                $category1->id,
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(4, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
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
                'next',
            ],
        ]);
    }

    public function test_authenticated_seller_user_can_only_list_your_products()
    {
        Product::factory()->count(4)->create();
        $user = $this->createAuthenticatedSeller();
        $store = $this->createStore($user);
        Product::factory(['store_id' => $store->id])->count(4)->create();

        $response = $this->getJson(route('product.index'));

        $response->assertOk();
        $response->assertJsonCount(4, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
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
                'next',
            ],
        ]);
    }

    public function test_authenticated_seller_user_can_list_your_products_filtered_by_search_param()
    {
        Product::factory()->count(4)->create();
        $user = $this->createAuthenticatedSeller();
        $store = $this->createStore($user);
        Product::factory(['store_id' => $store->id])->count(3)->create();
        Product::factory(['store_id' => $store->id, 'title' => 'jaime'])->create();
        Product::factory(['title' => 'jaime'])->create();

        $response = $this->getJson(route('product.index', [
            'search' => 'jaime',
        ]));

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
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
                'next',
            ],
        ]);
        $this->assertEquals('jaime', $response->json('data.0.title'));
    }

    public function test_authenticated_seller_user_can_list_your_products_filtered_by_categories_param()
    {
        $user = $this->createAuthenticatedSeller();
        $store = $this->createStore($user);

        /** @var Category $category1 */
        $category1 = Category::factory()->create();
        $products = Product::factory()->times(2)->create(['store_id' => $store->id]);
        $category1->products()->attach($products);
        Product::factory()->times(3)->create(['store_id' => $store->id]);

        /** @var Category $category2 */
        $category2 = Category::factory()->create();
        $products = Product::factory()->times(3)->create();
        $category2->products()->attach($products);

        $response = $this->getJson(route('product.index', [
            'categories' => [
                $category1->id,
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
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
                'next',
            ],
        ]);
    }

    public function test_authenticated_seller_user_can_list_your_products_filtered_by_collection_param()
    {
        $user = $this->createAuthenticatedSeller();
        $store = $this->createStore($user);

        /** @var Collection $collection1 */
        $collection1 = Collection::factory()->create();
        $products = Product::factory()->times(2)->create(['store_id' => $store->id]);
        $collection1->products()->attach($products);
        Product::factory()->times(3)->create(['store_id' => $store->id]);

        /** @var Collection $collection2 */
        $collection2 = Collection::factory()->create();
        $products = Product::factory()->times(3)->create();
        $collection2->products()->attach($products);

        $response = $this->getJson(route('product.index', [
            'collection' => $collection1->id,
        ]));

        $response->assertOk();
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
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
                'next',
            ],
        ]);
    }
}
