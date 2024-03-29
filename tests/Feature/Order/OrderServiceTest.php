<?php

namespace Tests\Feature\Order;

use App\Models\OrderDetail;
use App\Models\ShoppingCart;
use App\Models\User;
use App\Models\Variation;
use App\Services\OrderService;

class OrderServiceTest extends BaseTest
{
    public function test_an_app_user_can_generate_a_general_order_with_a_order_for_every_seller()
    {
        /** @var User $user */
        $user = $this->createAuthenticatedUser();
        $variations = Variation::factory()->count(3)->create();
        $variations->each(fn ($variation) => ShoppingCart::create([
            'customer_id' => $user->id,
            'customer_type' => User::class,
            'variation_id' => $variation->id,
            'quantity' => $this->faker->numberBetween(1, 4)
        ]));

        app(OrderService::class)->createFromShoppingCart($user->id);

        $this->assertDatabaseCount('orders', 4);
        $this->assertDatabaseCount('order_details', 6);
        $this->assertEquals(3, OrderDetail::groupBy('order_id')->count());
        // TODO : implement more assertions with price and user, seller
    }
}
