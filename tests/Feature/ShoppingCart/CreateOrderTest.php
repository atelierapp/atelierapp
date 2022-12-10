<?php

namespace Tests\Feature\ShoppingCart;

use App\Models\Order;
use App\Models\ShoppingCart;

class CreateOrderTest extends BaseTest
{
    /**
     * @test
     */
    public function cannot_create_an_order_for_guess_user(): void
    {
        $response = $this->postJson(route('shopping-cart.order'));

        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_create_an_order_if_shopping_cart_is_empty(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('shopping-cart.order'));

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'code',
            'message',
            'errors',
        ]);
    }

    /**
     * @test
     */
    public function can_create_an_order_from_shopping_cart_when_it_has_one_product(): void
    {
        $user = $this->createAuthenticatedUser();

        ShoppingCart::factory()->create([
            'customer_id' => $user->id,
        ]);

        $response = $this->postJson(route('shopping-cart.order'));

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertGreaterThan(1, Order::where('total_price', '>', '1')->sum('total_price'));
        $this->assertGreaterThan(1, Order::where('total_revenue', '>', '1')->sum('total_revenue'));
    }
}
