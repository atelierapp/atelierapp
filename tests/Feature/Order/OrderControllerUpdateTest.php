<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use Tests\TestCase;

class OrderControllerUpdateTest extends TestCase
{
    public function test_an_guess_user_cannot_update_any_order()
    {
        $response = $this->patchJson(route('order.update', 1));

        $response->assertUnauthorized();
    }

    public function test_an_app_user_cannot_update_any_order()
    {
        $this->createAuthenticatedUser();

        $response = $this->patchJson(route('order.update', 1));

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_cannot_update_his_order_without_params()
    {
        $user = $this->createAuthenticatedSeller();
        $order = Order::factory()->create(['seller_id' => $user->id]);

        $response = $this->patchJson(route('order.update', $order->id));

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'seller_status_id'
        ]);
    }

    public function test_an_seller_user_cannot_update_any_order_that_not_yours()
    {
        $this->createAuthenticatedSeller();
        $order = Order::factory()->create();

        $data = ['seller_status_id' => 2];
        $response = $this->patchJson(route('order.update', $order->id), $data);

        $response->assertNotFound();
    }

    public function test_an_seller_user_can_update_his_order_with_valid_params()
    {
        $user = $this->createAuthenticatedSeller();
        $order = Order::factory()->create(['seller_id' => $user->id]);

        $data = ['seller_status_id' => 2];
        $response = $this->patchJson(route('order.update', $order->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "user_id",
                "user" => [
                    "id",
                    "first_name",
                    "last_name",
                    "full_name",
                    "email",
                    "phone",
                    "avatar",
                ],
                "seller_id",
                "seller" => [
                    "id",
                    "first_name",
                    "last_name",
                    "full_name",
                    "email",
                    "phone",
                    "avatar",
                ],
                "items",
                "total_price",
                "seller_status",
                "seller_status_at",
                "paid_status",
                "paid_on",
            ],
        ]);
    }
}
