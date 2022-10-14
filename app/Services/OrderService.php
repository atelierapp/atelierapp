<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShoppingCart;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\InterfaceString;

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
    public function getByAuthRole(Order|string|int $order, string $field = 'id', $throwable = true): Order
    {
        if ($order instanceof Order) {
            return $order;
        }

        $query = Order::where($field, '=', $order)->filterByAuthenticatedRole();

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

        if (count($items) == 0) {
            throw new AtelierException('You do not have products in your shopping cart', 422);
        }

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
            $order->save();

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

        $parentOrder->total_price = $parentOrder->subOrders()->sum('total_price');
        $parentOrder->items = $parentOrder->subOrders()->sum('items');

        return $parentOrder;
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    public function sellerApproval(Order|string|int $orderId): Order
    {
        $order = $this->validateIfTheOrderBelongsToTheAuthenticatedSeller($orderId);
        $order->seller_status = Order::_SELLER_APPROVAL;
        $order->seller_accepted_on = now();
        $order->save();

        return $order;
    }

    public function saleApproval(Order|string|int $orderId): Order
    {
        $order = $this->getBy($orderId);
        // $order->payment_gateway_code = some value; TODO: view to add the value from payment gateway
        $order->paid_status = Invoice::PAYMENT_APPROVAL;
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

    public function updateSellerStatus(Int|string|Order $order, int|string $statusId): Order
    {
        $order = $this->getByAuthRole($order);
        $order->seller_status_id = $statusId;
        $order->seller_status_at = now();
        $order->save();

        return $order;
    }

    // TODO refactor this implement to service o better architecture to manage gateways
    public function updatePaymentGateway(Order $order, int $paymentGatewayId, string $code): Order
    {
        $order->update([
            'payment_gateway_id' => $paymentGatewayId,
            'payment_gateway_code' => $code,
            'paid_status_id' => 1,
            'paid_on' => null,
        ]);

        Order::where('parent_id', '=', $order->id)
            ->update([
                'payment_gateway_id' => $paymentGatewayId,
                'payment_gateway_code' => $code,
            ]);

        return $order;
    }

    // TODO refactor this implement to service o better architecture to manage gateways
    public function updateToPayedStatus(Order $order, array $metadata): Order
    {
        $order->update([
            'paid_status_id' => Invoice::PAYMENT_APPROVAL,
            'paid_on' => now(),
            'payment_gateway_metadata' => [
                'response_payment' => $metadata,
            ],
        ]);

        return $order;
    }

    public function updateToPendingApprovalStatus(Order $order): Order
    {
        $order->update([
            'paid_status_id' => Invoice::PAYMENT_PENDING_APPROVAL,
            'paid_on' => now(),
        ]);

        Order::where('parent_id', '=', $order->id)
            ->update([
                'paid_status_id' => Invoice::PAYMENT_PENDING_APPROVAL,
                'paid_on' => now(),
            ]);

        return $order;
    }

    public function updatePaymentGatewayMetadata(Order $order, string $node, array $params)
    {
        $values = $order->payment_gateway_metadata;
        $values[$node] = $params;
        $order->payment_gateway_metadata = $values;
        $order->save();
    }
}
