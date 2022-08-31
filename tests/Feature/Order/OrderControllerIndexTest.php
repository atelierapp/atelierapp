<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\Store;
use Tests\TestCase;

class OrderControllerIndexTest extends TestCase
{
    public function test_an_guess_user_can_not_list_orders()
    {
        $response = $this->getJson(route('order.index'));

        $response->assertUnauthorized();
    }

    public function test_an_authenticated_seller_user_can_list_all_orders()
    {
        $user = $this->createAuthenticatedSeller();
        $store = Store::factory()->create([
            'user_id' => $user->id,
        ]);
        Order::factory()
            ->count(5)
            ->sellerPending()
            ->hasDetails(5)
            ->create([
                'store_id' => $store->id,
                'seller_id' => $user->id,
            ]);
        Order::factory()
            ->count(5)
            ->sellerPending()
            ->hasDetails(5)
            ->create();

        $response = $this->getJson(route('order.index'));

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'user_id',
                    'user' => [
                        'id',
                        'first_name',
                        'last_name',
                        'full_name',
                        'email',
                        'phone',
                        'avatar',
                    ],
                    'seller_id',
                    'seller' => [
                        'id',
                        'first_name',
                        'last_name',
                        'full_name',
                        'email',
                        'phone',
                        'avatar',
                    ],
                    'items',
                    'total_price',
                    'seller_status',
                    'seller_accepted_on',
                    'paid_status',
                    'paid_on',
                ],
            ],
        ]);
    }

    public function test_an_authenticated_seller_user_can_list_inbound_or_pending_orders()
    {
        $user = $this->createAuthenticatedSeller();
        $store = Store::factory()->create([
            'user_id' => $user->id,
        ]);
        $params = [
            'store_id' => $store->id,
            'seller_id' => $user->id,
        ];
        Order::factory()->count(3)->sellerPending()->create($params);
        Order::factory()->count(3)->sellerApproved()->create($params);

        $response = $this->getJson(route('order.index', [
            'seller_status_id' => Order::SELLER_PENDING
        ]));

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'user_id',
                    'user' => [
                        'id',
                        'first_name',
                        'last_name',
                        'full_name',
                        'email',
                        'phone',
                        'avatar',
                    ],
                    'seller_id',
                    'seller' => [
                        'id',
                        'first_name',
                        'last_name',
                        'full_name',
                        'email',
                        'phone',
                        'avatar',
                    ],
                    'items',
                    'total_price',
                    'seller_status',
                    'seller_accepted_on',
                    'paid_status',
                    'paid_on',
                ],
            ],
        ]);
    }

    public function test_an_authenticated_app_user_user_can_list_all_orders()
    {
        $user = $this->createAuthenticatedUser();
        Order::factory()
            ->count(3)
            ->sellerPending()
            ->hasDetails(5)
            ->create([
                'user_id' => $user->id,
            ]);
        Order::factory()
            ->count(5)
            ->sellerPending()
            ->hasDetails(5)
            ->create();

        $response = $this->getJson(route('order.index'));

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'user_id',
                    'user' => [
                        'id',
                        'first_name',
                        'last_name',
                        'full_name',
                        'email',
                        'phone',
                        'avatar',
                    ],
                    'seller_id',
                    'seller' => [
                        'id',
                        'first_name',
                        'last_name',
                        'full_name',
                        'email',
                        'phone',
                        'avatar',
                    ],
                    'items',
                    'total_price',
                    'seller_status',
                    'seller_accepted_on',
                    'paid_status',
                    'paid_on',
                ],
            ],
        ]);
    }
}
