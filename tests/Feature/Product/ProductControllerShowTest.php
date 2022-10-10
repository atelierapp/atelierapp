<?php

namespace Tests\Feature\Product;

use App\Models\Product;

/**
 * @title Products
 * @group products
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerShowTest extends BaseTest
{
    public function test_a_guess_cannot_list_products()
    {
        $response = $this->getJson(route('product.show', 1), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function  test_a_normal_user_cannot_view_detail_of_unexists_product()
    {
        $this->createAuthenticatedUser();

        $response = $this->getJson(route('product.show', 1), $this->customHeaders());

        $response->assertNotFound();
    }

    public function  test_a_normal_user_can_view_detail_of_product()
    {
        $this->createAuthenticatedUser();
        $product = Product::factory()->create();

        $response = $this->getJson(route('product.show', $product->id), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
    }

    public function  test_a_admin_user_can_view_detail_of_product()
    {
        $this->createAuthenticatedAdmin();
        $product = Product::factory()->create();

        $response = $this->getJson(route('product.show', $product->id), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
    }

    public function  test_a_seller_user_can_view_detail_of_his_product()
    {
        $user = $this->createAuthenticatedSeller();
        $store = $this->createStore($user);
        $product = $this->createProduct($store);

        $response = $this->getJson(route('product.show', $product->id), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
    }

    public function  test_a_seller_user_cannot_view_detail_of_product_that_not_your()
    {
        $this->createAuthenticatedSeller();
        $product = Product::factory()->create();

        $response = $this->getJson(route('product.show', $product->id), $this->customHeaders());

        $response->assertNotFound();
    }

    public function test_when_product_is_viewed_increase_counter_and_save_a_new_record_on_database_through_a_job()
    {
        $user = $this->createAuthenticatedUser();
        $product = Product::factory()->create();

        $response = $this->getJson(route('product.show', $product->id), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'view_count' => 1
        ]);
        $this->assertDatabaseHas('product_views', [
            'product_id' => $product->id,
            'user_id' => $user->id
        ]);
    }
}
