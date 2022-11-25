<?php

namespace Tests\Feature\Order;

use App\Exceptions\AtelierException;
use App\Jobs\CapturePaymentFromPaypal;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Services\OrderService;
use Database\Seeders\OrderStatusSeeder;
use Database\Seeders\PaymentStatusSeeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class CheckOrderForSellerApprovalTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            OrderStatusSeeder::class,
            PaymentStatusSeeder::class,
        ]);
    }

    public function test_cannot_check_when_is_an_sub_order()
    {
        $service = app(OrderService::class);
        Order::factory()->has(Order::factory()->count(2)->sellerPending(), 'subOrders')->create();

        $this->expectException(AtelierException::class);
        $service->checkIfAllOrdersWereApproved(Order::find(2));
    }

    public function test_can_check_when_is_valid_order_and_can_not_capture_payment_when_sub_orders_not_approvals()
    {
        Bus::fake([
            CapturePaymentFromPaypal::class,
        ]);
        $service = app(OrderService::class);
        $order = Order::factory()
            ->has(Order::factory()
                ->count(2)
                ->state(new Sequence(
                    ['seller_status_id' => OrderStatus::_SELLER_PENDING],
                    ['seller_status_id' => OrderStatus::_SELLER_APPROVAL],
                )), 'subOrders')
            ->create();

        $service->checkIfAllOrdersWereApproved($order);

        Bus::assertNotDispatched(CapturePaymentFromPaypal::class);
    }

    public function test_can_check_when_is_valid_order_and_can_capture_payment_when_sub_orders_is_approvals()
    {
        Bus::fake([
            CapturePaymentFromPaypal::class,
        ]);

        $service = app(OrderService::class);
        $order = Order::factory()
            ->has(Order::factory()->count(2)
                ->state(new Sequence(
                    ['seller_status_id' => OrderStatus::_SELLER_APPROVAL],
                    ['seller_status_id' => OrderStatus::_SELLER_APPROVAL],
                )), 'subOrders')
            ->create();

        $service->checkIfAllOrdersWereApproved($order);

        Bus::assertDispatched(CapturePaymentFromPaypal::class);
    }
}
