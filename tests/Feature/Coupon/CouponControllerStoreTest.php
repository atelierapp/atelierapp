<?php

namespace Tests\Feature\Coupon;

class CouponControllerStoreTest extends BaseTest
{
    public function test_an_guess_user_cannot_create_any_coupon()
    {
        $response = $this->postJson(route('coupon.store'));

        $response->assertUnauthorized();
    }
}
