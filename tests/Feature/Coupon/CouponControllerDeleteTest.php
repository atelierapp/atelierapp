<?php

namespace Tests\Feature\Coupon;

use App\Models\Coupon;
use App\Models\Store;

class CouponControllerDeleteTest extends BaseTest
{
    public function test_an_guess_user_update_create_any_coupon()
    {
        $response = $this->deleteJson(route('coupon.destroy', 1));

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_cannot_delete_a_coupon_if_it_belongs_to_his()
    {
        $this->createAuthenticatedSeller();
        $coupon = Coupon::factory()->create();

        $response = $this->deleteJson(route('coupon.destroy', $coupon->id), $this->customHeaders());

        $response->assertNotFound();
    }

    public function test_an_seller_user_can_delete_a_coupon_if_it_belongs_to_his()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();
        $coupon = Coupon::factory()->create(['store_id' => $store->id]);

        $response = $this->deleteJson(route('coupon.destroy', $coupon->id), $this->customHeaders());

        $response->assertNoContent();
    }
}
