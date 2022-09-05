<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Arr;

class InvoiceService
{
    public function generateFromOrder(Order $order)
    {
        // TODO : implement validation if order was payed

        $orderData = Arr::except($order->toArray(), [
            'unit_price',
            'payment_gateway_code',
            'paid_status_id',
            'paid_on',
        ]);
        $orderData['order_id'] = $order->id;

        $invoice = Invoice::create($orderData);

        $order->load('details')->details->each(fn ($detail) => $this->replicateDetailFromOrderDetail($invoice->id, $detail));

        return $invoice->load([
            'details.product',
            'details.variation',
        ]);
    }

    public function replicateDetailFromOrderDetail(int $invoiceId, OrderDetail $orderDetail)
    {
        return InvoiceDetail::create([
            'invoice_id' => $invoiceId,
            'product_id' => $orderDetail->product_id,
            'variation_id' => $orderDetail->variation_id,
            'unit_price' => $orderDetail->unit_price,
            'quantity' => $orderDetail->quantity,
            'total_price' => $orderDetail->total_price,
        ]);
    }
}
