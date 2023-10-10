<?php

namespace ShoppingCart;

use App\Models\Variation;
use Tests\Feature\ShoppingCart\BaseTest;

class UploadVariationInShoppingCartTest extends BaseTest
{
    public function test_an_authenticated_user_can_update_his_variation_quantity_and_price()
    {
        $user = $this->createAuthenticatedUser();
        $variation = Variation::factory()->create();
        $quantity = $this->faker->numberBetween(1, 5);
        $price = $this->faker->numberBetween(150, 120);

        $response = $this->postJson(route('shopping-cart.update'), [
            'variation_id' => $variation->id,
            'quantity' => $quantity,
            'price' => $price
        ]);

        $response->assertOk();
        $this->assertDatabaseCount('shopping_cart', 1);
        $this->assertDatabaseHas('shopping_cart', [
            'customer_id' => $user->id,
            'variation_id' => $variation->id,
            'quantity' => $quantity,
            'price' => $price * 100,
        ]);
    }

    public function test_an_authenticated_user_can_update_his_variation_quantity_and_price_get_from_related_product()
    {
        $user = $this->createAuthenticatedUser();
        $variation = Variation::factory()->create();
        $quantity = $this->faker->numberBetween(1, 5);

        $response = $this->postJson(route('shopping-cart.update'), [
            'variation_id' => $variation->id,
            'quantity' => $quantity,
        ]);

        $response->assertOk();
        $this->assertDatabaseCount('shopping_cart', 1);
        $this->assertDatabaseHas('shopping_cart', [
            'customer_id' => $user->id,
            'variation_id' => $variation->id,
            'quantity' => $quantity,
            'price' => ($variation->product->price * $quantity) * 100,
        ]);
    }

    public function test_an_authenticated_user_can_not_update_without_quantity_param()
    {
        $this->createAuthenticatedUser();
        $variation = Variation::factory()->create();

        $response = $this->postJson(route('shopping-cart.update'), [
            'variation_id' => $variation->id,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrorFor('quantity');
    }

    public function test_an_authenticated_user_can_not_update_without_variation_id_param()
    {
        $this->createAuthenticatedUser();
        $quantity = $this->faker->numberBetween(1, 5);

        $response = $this->postJson(route('shopping-cart.update'), [
            'quantity' => $quantity,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrorFor('variation_id');
    }

    public function test_an_authenticated_user_can_not_update_with_invalid_variation_id_param()
    {
        $this->createAuthenticatedUser();
        $quantity = $this->faker->numberBetween(1, 5);

        $response = $this->postJson(route('shopping-cart.update'), [
            'variation_id' => 99,
            'quantity' => $quantity,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrorFor('variation_id');
    }
}
