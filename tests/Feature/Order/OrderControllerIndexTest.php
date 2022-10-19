<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\Store;

class OrderControllerIndexTest extends BaseTest
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

        $response = $this->getJson(route('order.index'), $this->customHeaders());

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
                    'seller_status_at',
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
            'seller_status_id' => Order::_SELLER_PENDING
        ]), $this->customHeaders());

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
                    'seller_status_at',
                    'paid_status',
                    'paid_on',
                ],
            ],
        ]);
    }

    public function test_an_authenticated_app_user_user_can_list_all_orders()
    {
        $user = $this->createAuthenticatedUser();
        Order::factory()->count(3)->sellerPending()->hasDetails(5)->create(['user_id' => $user->id]);
        Order::factory()->count(5)->sellerPending()->hasDetails(5)->create();

        $response = $this->getJson(route('order.index'), $this->customHeaders());

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
                    'seller_status_at',
                    'paid_status',
                    'paid_on',
                ],
            ],
        ]);
    }

    public function test_an_authenticated_app_user_user_can_list_all_orders_filtered_by_store()
    {
        $user = $this->createAuthenticatedUser();
        $store = Store::factory()->create();
        Order::factory()->count(3)->create(['user_id' => $user->id, 'store_id' => $store->id]);
        Order::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson(route('order.index', [
            'store_id' => $store->id,
        ]), $this->customHeaders());

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
                    'seller_status_at',
                    'paid_status',
                    'paid_on',
                ],
            ],
        ]);
    }

    public function test_an_authenticated_app_user_user_can_list_all_orders_filtered_by_range_date()
    {
        $user = $this->createAuthenticatedUser();
        Order::factory()->create(['user_id' => $user->id, 'created_at' => '2022-10-18']);
        Order::factory()->create(['user_id' => $user->id, 'created_at' => '2022-10-19']);
        Order::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson(route('order.index', [
            'start_date' => '2022-10-18',
            'end_date' => '2022-10-19',
        ]), $this->customHeaders());

        $response->assertOk();
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
                    'seller_status_at',
                    'paid_status',
                    'paid_on',
                ],
            ],
        ]);
        $this->assertGreaterThanOrEqual(2, count($response->json('data')));
        $this->assertLessThan(5, count($response->json('data')));
    }
}
