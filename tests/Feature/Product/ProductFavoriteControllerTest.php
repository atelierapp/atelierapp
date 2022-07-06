<?php

namespace Tests\Feature\Product;

use App\Models\Product;
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
}
