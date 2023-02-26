<?php

namespace Tests\Feature\Coupon;

use App\Models\Coupon;
use App\Models\Store;

class CouponControllerIndexTest extends BaseTest
{
    public function test_an_guess_can_not_list_coupons()
    {
        $response = $this->getJson(route('coupon.index'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_app_user_can_not_list_coupons()
    {
        $this->createAuthenticatedUser();
        $response = $this->getJson(route('coupon.index'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_admin_user_can_list_all_coupons()
    {
        $this->createAuthenticatedAdmin();
        Coupon::factory()->count(5)->create();

        $response = $this->getJson(route('coupon.index'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
            ],
        ]);
    }

    public function test_an_seller_user_can_list_all_his_coupons()
    {
        $user = $this->createAuthenticatedSeller();
        $store = Store::factory()->create(['user_id' => $user->id]);
        Coupon::factory()->count(5)->create(['store_id' => $store->id]);
        Coupon::factory()->count(5)->create();

        $response = $this->getJson(route('coupon.index'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure(),
            ],
        ]);
    }
}
