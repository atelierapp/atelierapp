<?php

namespace Tests\Feature\Coupon;

use App\Models\Coupon;

class CouponControllerIndexTest extends BaseTest
{

    public function test_a_guess_can_not_list_coupons()
    {
        $response = $this->getJson(route('coupon.index'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_a_guess_can_3not_list_coupons()
    {
        Coupon::factory()->count(5)->create();

        $response = $this->getJson(route('coupon.index'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(['data' => [0 => $this->structure()]]);
    }
}
