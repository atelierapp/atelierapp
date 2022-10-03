<?php

namespace Tests\Feature\Profile;

use App\Models\Order;
use Tests\TestCase;

class ProfileOrderController extends TestCase
{
    public function test_a_guess_cannot_list_profile_orders(): void
    {
        $response = $this->getJson(route('profile.orders'));

        $response->assertUnauthorized();
    }

    public function test_auth_app_user_can_list_his_profile_orders(): void
    {
        $user = $this->createAuthenticatedUser();
        Order::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson(route('profile.orders'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'user_id',
                    'user',
                    'seller_id',
                    'seller',
                    'items',
                    'total_price',
                    'seller_status',
                    'seller_status_at',
                    'paid_status',
                    'paid_on',
                ]
            ]
        ]);
    }
}
