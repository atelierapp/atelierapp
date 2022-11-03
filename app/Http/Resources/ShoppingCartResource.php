<?php

namespace App\Http\Resources;

use App\Models\Device;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ShoppingCart */
class ShoppingCartResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user_id' => $this->resource->customer_id, // temporary field. Should be removed after next iOS update
            'customer_id' => $this->resource->customer_id,
            'has_user' => $this->resource->customer_type === User::class,
            'store_name' => $this->variation->product->store->name,
            'variation_id' => $this->variation_id,
            'quantity' => $this->quantity,
            'variation' => VariationResource::make($this->whenLoaded('variation')),
            'user' => $this->when($this->relationLoaded('customer'), function () {
                    return $this->resource->customer instanceof User ? new UserResource($this->resource->customer) : null;
            }),
            'device' => $this->when($this->relationLoaded('customer'), function () {
                    return $this->resource->customer instanceof Device ? new DeviceResource($this->resource->customer) : null;
            })
        ];
    }
}
