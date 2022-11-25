<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckOrderToCapturePaypalPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        Order::select(['parent_id'])
            ->whereNotNull('parent_id')
            ->where('paid_status_id', '=', PaymentStatus::PAYMENT_APPROVAL)
            ->where('seller_status_id', '=', OrderStatus::_SELLER_APPROVAL)
            ->where('created_at', '>=', now()->addHours(25))
            ->groupBy('parent_id')
            ->get()
            ->each(fn ($order) => CapturePaymentFromPaypal::dispatch($order->parent_id));
    }
}
