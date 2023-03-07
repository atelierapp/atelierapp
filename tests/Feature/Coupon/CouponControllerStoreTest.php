<?php

namespace Tests\Feature\Coupon;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Carbon;

class CouponControllerStoreTest extends BaseTest
{
    public function test_an_guess_user_cannot_create_any_coupon()
    {
        $response = $this->postJson(route('coupon.store'));

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_cannot_create_a_total_coupon_without_params()
    {
        $this->createAuthenticatedSeller();

        $data = [];
        $response = $this->postJson(route('coupon.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'code',
            'name',
            'mode',
            'is_fixed',
            'amount',
        ]);
    }

    public function test_an_seller_user_cannot_create_a_total_coupon()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_TOTAL,
            'is_fixed' => true,
            'amount' => 10,
        ];
        $response = $this->postJson(route('coupon.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'mode'
        ]);
        $this->assertDatabaseCount('coupons', 0);
    }

    public function test_an_seller_user_cannot_create_a_influencer_coupon()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_INFLUENCER,
            'is_fixed' => true,
            'amount' => 10,
        ];
        $response = $this->postJson(route('coupon.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'mode'
        ]);
        $this->assertDatabaseCount('coupons', 0);
    }

    public function test_an_seller_user_can_create_a_seller_fixed_coupon_with_minimal_params()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_SELLER,
            'is_fixed' => true,
            'amount' => 10,
        ];
        $response = $this->postJson(route('coupon.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $data['store_id'] = $store->id;
        $this->assertDatabaseHas('coupons', $data);
    }

    public function test_an_seller_user_can_create_a_seller_percent_coupon_with_minimal_params()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_SELLER,
            'is_fixed' => true,
            'amount' => 10,
        ];
        $response = $this->postJson(route('coupon.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $data['store_id'] = $store->id;
        $this->assertDatabaseHas('coupons', $data);
    }

    public function test_an_seller_user_can_create_a_seller_percent_coupon_with_interval_params()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_SELLER,
            'is_fixed' => true,
            'amount' => 10,
            'start_date' => '2023-03-01',
            'end_date' => '2023-03-31',
        ];
        $response = $this->postJson(route('coupon.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $data['start_date'] = Carbon::parse($data['start_date'])->toDateTimeString();
        $data['end_date'] = Carbon::parse($data['end_date'])->toDateTimeString();
        $data['store_id'] = $store->id;
        $this->assertDatabaseHas('coupons', $data);
    }

    public function test_an_seller_user_can_not_create_a_seller_percent_coupon_if_end_date_field_is_less_than_start_date()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_SELLER,
            'is_fixed' => true,
            'amount' => 10,
            'start_date' => '2023-03-31',
            'end_date' => '2023-03-01',
        ];
        $response = $this->postJson(route('coupon.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'end_date',
        ]);
    }

    public function test_an_seller_user_can_create_a_seller_percent_coupon_with_maximum_number_of_uses()
    {
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_SELLER,
            'is_fixed' => true,
            'amount' => 10,
            'max_uses' => 1000,
        ];
        $response = $this->postJson(route('coupon.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $data['store_id'] = $store->id;
        $this->assertDatabaseHas('coupons', $data);
    }

    public function test_an_seller_user_can_not_create_a_product_percent_coupon_without_products()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_PRODUCT,
            'is_fixed' => true,
            'amount' => 15,
        ];
        $response = $this->postJson(route('coupon.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'products'
        ]);
    }

    public function test_an_seller_user_can_create_a_product_percent_coupon_with_products_but_only_for_his_products()
    {
        Product::factory()->count(3)->create();
        $store = Store::factory(['user_id' => $this->createAuthenticatedSeller()->id])->create();
        Product::factory(['store_id' => $store->id])->count(3)->create();

        $data = [
            'code' => $this->faker->lexify('??????'),
            'name' => $this->faker->name(),
            'mode' => Coupon::MODE_PRODUCT,
            'is_fixed' => true,
            'amount' => 15,
            'products' => Product::select('id')->get()->pluck('id')->toArray(),
        ];
        $response = $this->postJson(route('coupon.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $this->assertDatabaseCount('coupons', 1);
        $this->assertDatabaseCount('coupon_details', 3);
    }
}
