<?php

namespace Tests\Feature\Order;

use App\Models\Order;

class OrderDetailControllerIndexTest extends BaseTest
{
    public function test_an_guess_user_can_not_list_details_of_any_order()
    {
        $response = $this->getJson(route('order.details', 1));

        $response->assertUnauthorized();
    }

    public function test_an_authenticated_user_can_list_details_of_specified_order()
    {
        $user = $this->createAuthenticatedUser();
        $order = Order::factory()->sellerPending()->hasDetails(5)->create(['user_id' => $user->id]);

        $response = $this->getJson(route('order.details', $order->id), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'order_id',
                    'product_id',
                    'product' => [
                        'store'
                    ],
                    'variation_id',
                    'variation',
                ]
            ]
        ]);
    }
}
