<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShoppingCart;
use Illuminate\Support\Collection;

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

    public function getDetails(int|string $orderId): Collection
    {
        return OrderDetail::whereOrderId($orderId)->with(['product', 'variation'])->get();
    }

    public function createFromShoppingCart(int|string $userId): Order
    {
        $items = ShoppingCart::whereUserId($userId)->with('variation.product.store')->get();

        $parentOrder = Order::create([
            'user_id' => $items[0]->user_id,
        ]);
        foreach ($items as $item) {
            $store = $item->variation->product->store;
            $order = Order::updateOrCreate([
                'parent_id' => $parentOrder->id,
                'user_id' => $userId,
                'store_id' => $store->id,
                'seller_id' => $store->user_id,
            ]);
            $order->items += $item->quantity;
            $order->total_price += $item->variation->product->price * $item->quantity;

            $params = [
                'order_id' => $order->id,
                'product_id' => $item->variation->product_id,
                'variation_id' => $item->variation_id,
                'unit_price' => $item->variation->product->price,
                'quantity' => $item->quantity,
                'total_price' => $item->variation->product->price * $item->quantity,
            ];

            OrderDetail::create($params);
            $params['order_id'] = $parentOrder->id;
            OrderDetail::create($params);
        }

        return $parentOrder;
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    public function sellerApproval(Order|string|int $orderId): Order
    {
        $order = $this->validateIfTheOrderBelongsToTheAuthenticatedSeller($orderId);
        $order->seller_status = Order::SELLER_APPROVAL;
        $order->seller_accepted_on = now();
        $order->save();

        return $order;
    }

    public function saleApproval(Order|string|int $orderId): Order
    {
        $order = $this->getBy($orderId);
        // $order->payment_gateway_code = some value; TODO: view to add the value from payment gateway
        $order->paid_status = Order::PAYMENT_APPROVAL;
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
