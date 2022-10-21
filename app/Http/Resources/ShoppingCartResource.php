<?php

namespace App\Http\Resources;

use App\Models\ShoppingCart;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ShoppingCart */
class ShoppingCartResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user_id' => $this->user_id,
            'store_name' => $this->variation->product->store->name,
            'variation_id' => $this->variation_id,
            'quantity' => $this->quantity,
            'variation' => VariationResource::make($this->whenLoaded('variation')),
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
