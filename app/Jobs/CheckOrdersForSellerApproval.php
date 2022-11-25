<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckOrdersForSellerApproval implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private int $orderId)
    {
        //
    }

    public function handle(): void
    {
        $result = Order::selectRaw("count(id) as 'total'")
            ->selectRaw("sum(if(seller_status_id = " . OrderStatus::_SELLER_APPROVAL . ", 1, 0)) as 'approvals'")
            ->where('parent_id', $this->orderId)
            ->first();

        if ((int) $result->total == (int) $result->approvals) {
            CapturePaymentFromPaypal::dispatch($this->orderId);
        }
    }
}
