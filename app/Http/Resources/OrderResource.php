<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

/** @mixin Order
 */
class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        $resource = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => UserSimpleResource::make($this->user),
            'seller_id' => $this->seller_id,
            'seller' => UserSimpleResource::make($this->seller),
            'items' => $this->items,
            'total_price' => (double) $this->total_price,
            'seller_status_id' => $this->seller_status_id,
            'seller_status' => $this->seller_status->name,
            'seller_status_at' => $this->seller_status_at,
            'paid_status' => $this->paidStatus->name,
            'paid_on' => $this->paid_on,
            'shipping' => null,
            'created_at' => $this->created_at,
            'orders' => $this->orders,
        ];

        $metadata = is_null($this->parent_id)
            ? $this->payment_gateway_metadata
            : $this->parent->payment_gateway_metadata;

        if(isset($metadata['order_authorization'])) {
            $resource['shipping'] = Arr::get($metadata, 'order_authorization.purchase_units.0.shipping.address');
        }

        return $resource;
    }
}
