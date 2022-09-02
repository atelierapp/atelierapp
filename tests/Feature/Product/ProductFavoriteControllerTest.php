<?php

namespace Tests\Feature\Product;

use App\Models\FavoriteProduct;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductFavoriteControllerTest extends TestCase
{
    public function test_a_guess_cannot_create_any_product()
    {
        $response = $this->postJson(route('product.favorite', 1), []);

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_user_can_add_some_product_to_his_favorites()
    {
        $user = $this->createAuthenticatedUser();
        $product = Product::factory()->create();

        $response = $this->postJson(route('product.favorite', $product->id), []);

        $response->assertCreated();
        $this->assertDatabaseHas('favorite_products', [
           'user_id' => $user->id,
           'product_id' => $product->id
        ]);
    }

    public function test_a_authenticated_user_can_remove_an_product_from_his_favorites()
    {
        $user = $this->createAuthenticatedUser();
        $product = Product::factory()->create();
        DB::table('favorite_products')->insert(['user_id' => $user->id, 'product_id' => $product->id]);

        $response = $this->postJson(route('product.favorite', $product->id), []);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('favorite_products', [
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);
    }

    public function test_a_authenticated_seller_can_list_trending_products()
    {
        $user = $this->createAuthenticatedSeller();
        $store = Store::factory()->create(['user_id' => $user->id]);
        Product::factory()->count(5)->create();
        Product::factory()->count(15)->create(['store_id' => $store->id])->each(function ($product) {
            FavoriteProduct::factory()->count($this->faker->numberBetween(1, 5))->create(['product_id' => $product->id]);
            OrderDetail::factory()->count($this->faker->numberBetween(1, 5))->create(['product_id' => $product->id]);
        });

        $response = $this->getJson(route('product.trending'));
        
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'name',
                    'image',
                    'favorites',
                    'projects',
                ]
            ]
        ]);
    }
}
