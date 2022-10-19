<?php

namespace Tests\Feature\Order;

use App\Models\OrderDetail;
use App\Models\OrderStatus;

class OrderDetailControllerUpdateTest extends BaseTest
{
    public function test_an_guess_user_can_not_update_a_detail_of_any_order()
    {
        $response = $this->patchJson(route('order.details.update', [1, 1]),[], $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_authenticated_app_user_cannot_update_a_detail_of_order()
    {
        $this->createAuthenticatedUser();

        $data = [];
        $response = $this->patchJson(route('order.details.update', [1, 1]), $data, $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_authenticated_seller_user_can_update_status_from_pending_to_approval_status_of_detail_of_order()
    {
        $this->createAuthenticatedSeller();
        $detail = OrderDetail::factory()->sellerPending()->create();

        $data = [
            'seller_status_id' => OrderStatus::_SELLER_APPROVAL,
        ];
        $response = $this->patchJson(route('order.details.update', [$detail->order_id, $detail->id]), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'order_id',
                'product_id',
                'product',
                'variation_id',
                'variation',
                'seller_status_id',
                'seller_status_at',
                'seller_status'
            ],
        ]);
        self::assertEquals(OrderStatus::_SELLER_APPROVAL, $response->json('data.seller_status_id'));
        self::assertNotNull($response->json('data.seller_status_at'));
        self::assertDatabaseHas('order_details', [
            'id' => $detail->id,
            'seller_status_id' => $data['seller_status_id'],
        ]);
    }

    public function test_an_authenticated_seller_user_can_update_status_from_pending_to_approval_status_and_include_notes_of_detail_of_order()
    {
        $this->createAuthenticatedSeller();
        $detail = OrderDetail::factory()->sellerPending()->create(['seller_notes' => null]);

        $data = [
            'seller_status_id' => OrderStatus::_SELLER_APPROVAL,
            'seller_notes' => $this->faker->paragraph,
        ];
        $response = $this->patchJson(route('order.details.update', [$detail->order_id, $detail->id]), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'order_id',
                'product_id',
                'product',
                'variation_id',
                'variation',
                'seller_status_id',
                'seller_status_at',
                'seller_status'
            ],
        ]);
        self::assertEquals(OrderStatus::_SELLER_APPROVAL, $response->json('data.seller_status_id'));
        self::assertEquals($data['seller_notes'], $response->json('data.seller_notes'));
        self::assertNotNull($response->json('data.seller_status_at'));
        self::assertNotNull($response->json('data.seller_notes'));
        self::assertDatabaseHas('order_details', [
            'id' => $detail->id,
            'seller_status_id' => $data['seller_status_id'],
            'seller_notes' => $data['seller_notes'],
        ]);
    }
}
