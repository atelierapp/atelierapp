<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Http\Response;
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

    public function getByAuthRole(Order|string|int $order, string $field = 'id', $throwable = true): Order
    {
        if ($order instanceof Order) {
            return $order;
        }

        $query = Order::where($field, '=', $order)->filterByRole();

        return $throwable
            ? $query->firstOrFail()
            : $query->firstOrNew();
    }

    public function getDetails(int|string $orderId): Collection
    {
        return OrderDetail::where('order_id', $orderId)->with(['product.store', 'variation'])->get();
    }

    /**
     * @throws AtelierException
     */
    public function createFromShoppingCart(int $userId): Order
    {
        $items = ShoppingCart::query()
            ->where('customer_type', User::class)
            ->where('customer_id', $userId)
            ->with('variation.product.store')
            ->get();

        if (count($items) == 0) {
            throw new AtelierException('You do not have products in your shopping cart', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parentOrder = Order::create([
            'user_id' => $items[0]->customer_id,
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

        ShoppingCart::withoutGlobalScopes()
            ->where('customer_type', User::class)
            ->where('customer_id', $userId)
            ->delete();

        return $parentOrder;
    }

    /**
     * @throws AtelierException
     */
    public function sellerApproval(Order|string|int $orderId): Order
    {
        $order = $this->validateIfTheOrderBelongsToTheAuthenticatedSeller($orderId);
        $order->seller_status_id = OrderStatus::_SELLER_APPROVAL;
        $order->seller_accepted_on = now();
        $order->save();

        return $order;
    }

    public function saleApproval(Order|string|int $orderId): Order
    {
        $order = $this->getBy($orderId);
        // $order->payment_gateway_code = some value; TODO: view to add the value from payment gateway
        $order->paid_status_id = PaymentStatus::PAYMENT_APPROVAL;
        $order->paid_on = now();
        $order->save();

        return $order;
    }

    /**
     * @throws AtelierException
     */
    private function validateIfTheOrderBelongsToTheAuthenticatedSeller(Order|string|int $orderId): Order
    {
        $order = $this->getBy($orderId);

        if ($order->seller_id == auth()->id()) {
            throw new AtelierException('User not Authorized', Response::HTTP_FORBIDDEN);
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

         Order::query()
            ->withoutGlobalScopes()
            ->where('parent_id', '=', $order->id)
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
            'paid_status_id' => PaymentStatus::PAYMENT_APPROVAL,
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
            'paid_status_id' => PaymentStatus::PAYMENT_PENDING_APPROVAL,
            'paid_on' => now(),
        ]);

        Order::query()
            ->withoutGlobalScopes()
            ->where('parent_id', '=', $order->id)
            ->update([
                'paid_status_id' => $order->paid_status_id,
                'paid_on' => $order->paid_on,
            ]);

        return $order;
    }

    public function updatePaymentGatewayMetadata(Order $order, string $node, array $params): void
    {
        $values = $order->payment_gateway_metadata;
        $values[$node] = $params;
        $order->payment_gateway_metadata = $values;
        $order->save();
    }
}
