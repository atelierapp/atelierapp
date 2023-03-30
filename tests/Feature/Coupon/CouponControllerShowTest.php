<?php

namespace Tests\Feature\Coupon;

use App\Models\Coupon;
use App\Models\Store;

class CouponControllerShowTest extends BaseTest
{
    public function test_an_guess_user_con_not_show_any_coupon()
    {
        $response = $this->getJson(route('coupon.show', 1));

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_cannot_show_a_coupon_if_it_belongs_to_his()
    {
        $this->createAuthenticatedSeller();
        $coupon = Coupon::factory()->create();

        $response = $this->getJson(route('coupon.show', $coupon->id), $this->customHeaders());

        $response->assertNotFound();
    }

    public function test_an_seller_user_can_delete_a_coupon_if_it_belongs_to_his()
    {
        $user = $this->createAuthenticatedSeller();
        $coupon = Coupon::factory()->create([
            'store_id' => Store::factory(['user_id' => $user->id])
        ]);

        $response = $this->getJson(route('coupon.show', $coupon->id), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
    }
}
