<?php

namespace Tests\Feature\Coupon;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Carbon;

class CouponControllerUpdateTest extends BaseTest
{
    public function test_an_guess_user_update_create_any_coupon()
    {
        $response = $this->patchJson(route('coupon.update', 1));

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_cannot_update_a_coupon_if_it_belongs_to_his()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_SELLER,
            'is_fixed' => true,
            'amount' => 10,
        ];
        $response = $this->patchJson(route('coupon.update', 99), $data, $this->customHeaders());

        $response->assertNotFound();
    }

    public function test_an_seller_user_cannot_update_his_coupon_to_total_coupon()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();
        $coupon = Coupon::factory()->create(['store_id' => $store->id]);

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_TOTAL,
            'is_fixed' => true,
            'amount' => 10,
        ];
        $response = $this->patchJson(route('coupon.update', $coupon->id), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'mode'
        ]);
    }

    public function test_an_seller_user_cannot_update_his_coupon_to_influencer_coupon()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();
        $coupon = Coupon::factory()->create(['store_id' => $store->id]);

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_INFLUENCER,
            'is_fixed' => true,
            'amount' => 10,
        ];
        $response = $this->patchJson(route('coupon.update', $coupon->id), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'mode'
        ]);
    }

    public function test_an_seller_user_can_update_his_fixed_coupon_with_minimal_params()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();
        $coupon = Coupon::factory()->create(['store_id' => $store->id]);

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_SELLER,
            'is_fixed' => true,
            'amount' => 10,
        ];
        $response = $this->patchJson(route('coupon.update', $coupon->id), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $data['id'] = $store->user_id;
        $data['store_id'] = $store->id;
        $this->assertDatabaseHas('coupons', $data);
    }

    public function test_an_seller_user_can_update_his_coupon_with_minimal_params()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();
        $coupon = Coupon::factory()->create(['store_id' => $store->id]);

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_SELLER,
            'is_fixed' => true,
            'amount' => 10,
        ];
        $response = $this->patchJson(route('coupon.update', $coupon->id), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $data['id'] = $store->user_id;
        $data['store_id'] = $store->id;
        $this->assertDatabaseHas('coupons', $data);
    }

    public function test_an_seller_user_can_update_his_coupon_with_interval_params()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();
        $coupon = Coupon::factory()->create(['store_id' => $store->id]);

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_SELLER,
            'is_fixed' => true,
            'amount' => 10,
            'start_date' => '2023-03-01',
            'end_date' => '2023-03-31',
        ];
        $response = $this->patchJson(route('coupon.update', $coupon->id), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $data['id'] = $store->user_id;
        $data['store_id'] = $store->id;
        $data['start_date'] = Carbon::parse($data['start_date'])->toDateTimeString();
        $data['end_date'] = Carbon::parse($data['end_date'])->toDateTimeString();
        $this->assertDatabaseHas('coupons', $data);
    }

    public function test_an_seller_user_can_not_update_his_coupon_if_end_date_field_is_less_than_start_date()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();
        $coupon = Coupon::factory()->create(['store_id' => $store->id]);

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_SELLER,
            'is_fixed' => true,
            'amount' => 10,
            'start_date' => '2023-03-31',
            'end_date' => '2023-03-01',
        ];
        $response = $this->patchJson(route('coupon.update', $coupon->id), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'end_date',
        ]);
    }

    public function test_an_seller_user_can_update_his_coupon_with_maximum_number_of_uses()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();
        $coupon = Coupon::factory()->create(['store_id' => $store->id]);

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_SELLER,
            'is_fixed' => true,
            'amount' => 10,
            'max_uses' => 1000,
        ];
        $response = $this->patchJson(route('coupon.update', $coupon->id), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $data['id'] = $store->user_id;
        $data['store_id'] = $store->id;
        $this->assertDatabaseHas('coupons', $data);
    }

    public function test_an_seller_user_can_not_update_his_coupon_to_product_percent_coupon_without_products()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();
        $coupon = Coupon::factory()->create(['store_id' => $store->id]);

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_PRODUCT,
            'is_fixed' => true,
            'amount' => 15,
        ];
        $response = $this->patchJson(route('coupon.update', $coupon->id), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'products'
        ]);
    }

    public function test_an_seller_user_can_update_his_coupon_to_product_percent_coupon_with_products()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();
        $coupon = Coupon::factory()->create(['store_id' => $store->id]);
        Product::factory(['store_id' => $store->id])->count(3)->create();
        Product::factory()->count(3)->create();

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_PRODUCT,
            'is_fixed' => true,
            'amount' => 15,
            'products' => Product::select('id')->get()->pluck('id')->toArray(),
        ];
        $response = $this->patchJson(route('coupon.update', $coupon->id), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $this->assertDatabaseCount('coupon_details', 3);
    }
}
