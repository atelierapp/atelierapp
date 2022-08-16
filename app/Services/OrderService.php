<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\Order;

class OrderService
{
    public function getBy(Order|string|int $order, string $field = 'id', $throwable = true): Order
    {
        if ($order instanceof Order) {
            return $order;
        }

        $query = Order::where($field, '=', $order);

        return $throwable
            ? $query->firstOrFail()
            : $query->firstOrNew();

    }

    public function createFromShoppingCart()
    {

    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    public function sellerApproval(Order|string|int $orderId): Order
    {
        $order = $this->validateIfTheOrderBelongsToTheAuthenticatedSeller($orderId);
        $order->is_accepted = true;
        $order->accepted_on = now();
        $order->save();

        return $order;

    }

    public function saleApproval(Order|string|int $orderId): Order
    {
        $order = $this->getBy($orderId);
        // $order->payment_gateway_code = some value; TODO: view to add the value from payment gateway
        $order->is_paid = true;
        $order->paid_on = now();
        $order->save();

        return $order;
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    private function validateIfTheOrderBelongsToTheAuthenticatedSeller(Order|string|int $orderId): Order
    {
        $order = $this->getBy($orderId);

        if ($order->seller_id == auth()->id()) {
            throw new AtelierException('User not Authorized', 403);
        }

        return $order;
    }
}
