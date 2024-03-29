<?php

namespace Tests\Feature\Dashboard;

use App\Models\Order;
use App\Models\Store;
use Database\Seeders\OrderStatusSeeder;
use Database\Seeders\PaymentStatusSeeder;
use Tests\TestCase;

class DashboardNetIncomeTest extends TestCase
{
    public function test_an_guess_user_cannot_get_net_income()
    {
        $response = $this->getJson(route('dashboard.net-income'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_authenticated_seller_cannot_get_net_income_without_params()
    {
        $this->createAuthenticatedSeller();

        $response = $this->getJson(route('dashboard.net-income'), $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'start_date',
            'end_date'
        ]);
    }

    public function test_an_authenticated_seller_can_get_net_income_with_valid_dates()
    {
        $this->seed([
            OrderStatusSeeder::class,
            PaymentStatusSeeder::class
        ]);
        $user = $this->createAuthenticatedSeller();
        $store = Store::factory()->create(['user_id' => $user->id]);
        Order::factory()->count(50)->create([
            'store_id' => $store->id,
            'seller_id' => $user->id,
            'paid_on' => $this->faker->dateTimeBetween('2022-01-11', '2022-11-11')
        ]);

        $data = [
            'start_date' => '2022-01-01',
            'end_date' => '2022-11-11',
        ];
        $response = $this->getJson(route('dashboard.net-income', $data), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'average',
                'data' => [
                    0 => [
                        'paid_on',
                        'total_price',
                    ],
                ],
            ],
        ]);
    }
}
