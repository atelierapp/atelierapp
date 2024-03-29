<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Collection;
use App\Models\FavoriteProduct;
use App\Models\Product;
use App\Models\Store;
use JMac\Testing\Traits\AdditionalAssertions;

class ProductControllerIndexTest extends BaseTest
{
    use AdditionalAssertions;

    public function test_a_guess_can_list_products()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson(route('product.index'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(['data' => [0 => $this->structure()]]);
    }

    public function test_authenticated_app_user_can_list_all_active_products_from_active_stores()
    {
        $this->createAuthenticatedUser();
        Product::factory()->count(5)->active()->activeStore()->create();

        $response = $this->getJson(route('product.index'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
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
        $product = Product::factory()->count(5)->active()->activeStore()->create();
        FavoriteProduct::query()->create(['user_id' => $user->id, 'product_id' => $product[0]->id]);

        $response = $this->getJson(route('product.index'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
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
        Product::factory()->count(6)->active()->activeStore()->create();
        Product::factory(['title' => 'jaime'])->active()->activeStore()->create();
        Product::factory(['title' => 'jaime'])->active()->activeStore()->create();

        $response = $this->getJson(route('product.index', [
            'search' => 'jaime',
        ]), $this->customHeaders());

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
        $products = Product::factory()->times(4)->active()->activeStore()->create(); // 2
        $category1->products()->attach($products);

        /** @var Category $category2 */
        $category2 = Category::factory()->create();
        $products = Product::factory()->times(3)->active()->activeStore()->create(); // 3
        $category2->products()->attach($products);

        $response = $this->getJson(route('product.index', [
            'categories' => [
                $category1->id,
            ],
        ]), $this->customHeaders());

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

    public function test_authenticated_app_user_can_list_products_filtered_by_category_name_using_search_param()
    {
        $this->createAuthenticatedUser();
        Product::factory()->times(4)->create();
        $category = Category::factory()->create();
        $category->products()->attach(Product::inRandomOrder()->first());

        $response = $this->getJson(route('product.index', [
            'search' => $category->name,
        ]), $this->customHeaders());

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
    }

    public function test_authenticated_app_user_can_list_products_filtered_by_store_id_param()
    {
        $this->createAuthenticatedUser();

        $store = Store::factory()->active()->create();
        Product::factory()->count(3)->active()->create(['store_id' => $store->id]);
        Product::factory()->count(3)->active()->us()->create(['store_id' => $store->id]);
        Product::factory()->count(3)->active()->create();
        Product::factory()->count(3)->active()->us()->create();

        $response = $this->getJson(route('product.index', [
            'store_id' => $store->id,
        ]), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
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

    public function test_authenticated_app_user_can_list_2_products_filtered_by_specified_price_range()
    {
        $this->createAuthenticatedUser();

        Product::factory()->active()->activeStore()->create(['price' => 2000]);
        Product::factory()->active()->activeStore()->create(['price' => 8000]);
        Product::factory()->count(2)->active()->activeStore()->create();
        Product::factory()->us()->count(2)->active()->activeStore()->create();

        $response = $this->getJson(route('product.index', [
            'price-min' => 10,
            'price-max' => 90,
        ]), $this->customHeaders());

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

    public function test_authenticated_app_user_can_list_products_ascending_by_price()
    {
        $this->createAuthenticatedUser();

        Product::factory()->count(10)->create();

        $response = $this->getJson(route('product.index', [
            'sort' => [
                'field' => 'price',
                'dir' => 'asc'
            ],
        ]), $this->customHeaders());

        $response->assertOk();
        $this->assertLessThanOrEqual($response->json('data.1.price'), $response->json('data.0.price'));
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

    public function test_authenticated_app_user_can_list_products_descending_by_price()
    {
        $this->createAuthenticatedUser();

        Product::factory()->count(10)->create();

        $response = $this->getJson(route('product.index', [
            'sort' => [
                'field' => 'price',
                'dir' => 'desc'
            ],
        ]), $this->customHeaders());

        $response->assertOk();
        $this->assertGreaterThanOrEqual($response->json('data.1.price'), $response->json('data.0.price'));
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

    public function test_authenticated_app_user_can_list_products_ascending_by_title()
    {
        $this->createAuthenticatedUser();

        Product::factory()->count(10)->create();

        $response = $this->getJson(route('product.index', [
            'sort' => [
                'field' => 'title',
                'dir' => 'asc'
            ],
        ]), $this->customHeaders());

        $response->assertOk();
        $this->assertLessThanOrEqual($response->json('data.1.title'), $response->json('data.0.title'));
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

    public function test_authenticated_app_user_can_list_products_descending_by_title()
    {
        $this->createAuthenticatedUser();

        Product::factory()->count(10)->create();

        $response = $this->getJson(route('product.index', [
            'sort' => [
                'field' => 'title',
                'dir' => 'desc'
            ],
        ]), $this->customHeaders());

        $response->assertOk();
        $this->assertGreaterThanOrEqual($response->json('data.1.title'), $response->json('data.0.title'));
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

    public function test_authenticated_app_user_can_list_products_ascending_by_score()
    {
        $this->createAuthenticatedUser();

        Product::factory()->count(10)->create();

        $response = $this->getJson(route('product.index', [
            'sort' => [
                'field' => 'score',
                'dir' => 'asc'
            ],
        ]), $this->customHeaders());

        $response->assertOk();
        $this->assertLessThanOrEqual($response->json('data.1.score'), $response->json('data.0.score'));
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

    public function test_authenticated_app_user_can_list_products_descending_by_score()
    {
        $this->createAuthenticatedUser();

        Product::factory()->count(10)->create();

        $response = $this->getJson(route('product.index', [
            'sort' => [
                'field' => 'score',
                'dir' => 'desc'
            ],
        ]), $this->customHeaders());

        $response->assertOk();
        $this->assertGreaterThanOrEqual($response->json('data.1.score'), $response->json('data.0.score'));
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
        Product::factory()->count(8)->active()->activeStore()->create();

        $response = $this->getJson(route('product.index'), $this->customHeaders());

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
        Product::factory()->count(6)->active()->activeStore()->create();
        Product::factory(['title' => 'jaime'])->active()->activeStore()->create();
        Product::factory(['title' => 'jaime'])->active()->activeStore()->create();

        $response = $this->getJson(route('product.index', [
            'search' => 'jaime',
        ]), $this->customHeaders());

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
        $products = Product::factory()->times(4)->active()->activeStore()->create(); // 2
        $category1->products()->attach($products);

        /** @var Category $category2 */
        $category2 = Category::factory()->create();
        $products = Product::factory()->times(3)->active()->activeStore()->create(); // 3
        $category2->products()->attach($products);

        $response = $this->getJson(route('product.index', [
            'categories' => [
                $category1->id,
            ],
        ]), $this->customHeaders());

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

    public function test_guess_user_can_list_only_canvas_product_use_to_render_in_app()
    {
        /** @var Category $category1 */
        $category1 = Category::factory()->create(['type' => 'canvas']);
        $products = Product::factory()->times(2)->active()->activeStore()->create(); // 2
        $category1->products()->attach($products);

        /** @var Category $category2 */
        $category2 = Category::factory()->create(['type' => null]);
        $products = Product::factory()->times(2)->active()->activeStore()->create(); // 2
        $category2->products()->attach($products);

        $response = $this->getJson(route('product.index', [
            'type' => 'canvas',
        ]), $this->customHeaders());

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

    public function test_authenticated_seller_user_can_only_list_your_products()
    {
        Product::factory()->count(4)->create();
        $user = $this->createAuthenticatedSeller();
        $store = $this->createStore($user);
        Product::factory(['store_id' => $store->id])->count(4)->active()->create();

        $response = $this->getJson(route('product.index'), $this->customHeaders());

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
        ]), $this->customHeaders());

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
        ]), $this->customHeaders());

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
        ]), $this->customHeaders());

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
