<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'product' => ProductResource::make($this->product),
            'variation_id' => $this->variant_id,
            'variation' => VariationResource::make($this->variation),
        ];
    }
}
