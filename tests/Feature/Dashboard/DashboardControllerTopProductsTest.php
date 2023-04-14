<?php

namespace Tests\Feature\Dashboard;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Store;
use Database\Seeders\OrderStatusSeeder;
use Database\Seeders\PaymentStatusSeeder;

class DashboardControllerTopProductsTest extends Basetest
{
    public function test_an_guess_user_cannot_get_top_product()
    {
        $response = $this->getJson(route('dashboard.top-product'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_can_get_top_product()
    {
        $this->seed([
            OrderStatusSeeder::class,
            PaymentStatusSeeder::class,
        ]);
        $user = $this->createAuthenticatedSeller();
        $store = Store::factory()->create(['user_id' => $user->id]);
        Product::factory()->count(10)->create(['store_id' => $store->id])
            ->each(function ($product) use ($user) {
                $order = Order::factory()->create(['seller_id' => $user->id]);
                OrderDetail::factory()
                    ->count($this->faker->numberBetween(1,3))
                    ->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id
                    ]);
            });

        $response = $this->getJson(route('dashboard.top-product'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'image',
                    'name',
                    'availability',
                    'sales',
                ],
            ],
        ]);
    }
}
