<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'product' => ProductResource::make($this->product),
            'variation_id' => $this->variant_id,
            'variation' => VariationResource::make($this->variation),
            'unit_price' => $this->unit_price,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'seller_status_id' => $this->seller_status_id,
            'seller_status_at' => $this->seller_status_at,
            'seller_status' => $this->seller_status,
            'seller_notes' => $this->seller_notes,
        ];
    }
}
