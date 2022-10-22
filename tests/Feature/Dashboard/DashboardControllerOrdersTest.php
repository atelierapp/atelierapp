<?php

namespace Tests\Feature\Dashboard;

use App\Models\Order;
use App\Models\Product;

class DashboardControllerOrdersTest extends BaseTest
{
    public function test_an_guess_user_cannot_get_orders()
    {
        $response = $this->getJson(route('dashboard.orders'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_can_get_orders()
    {
        $user = $this->createAuthenticatedSeller();
        Order::factory()->count(10)->create(['seller_id' => $user->id]);

        $response = $this->getJson(route('dashboard.orders'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'product',
                    'price',
                    'is_accepted',
                    'delivery_notes',
                ],
            ],
        ]);
    }
}
