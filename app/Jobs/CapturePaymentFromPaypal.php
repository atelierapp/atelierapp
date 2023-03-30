<?php

namespace App\Jobs;

use App\Exceptions\AtelierException;
use App\Models\Order;
use App\Models\PaymentStatus;
use App\Services\PaypalService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Response;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CapturePaymentFromPaypal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private int $orderId)
    {
        //
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        $order = Order::withoutGlobalScopes()->whereId($this->orderId)->whereNull('parent_id')->firstOrFail();

        if ($order->paid_status_id != PaymentStatus::PAYMENT_APPROVAL) {
            throw new AtelierException(__('order.errors.invalid_order_to_capture'), Response::HTTP_CONFLICT);
        }

        app(PaypalService::class)->capturePaymentOrder($order);
    }
}
