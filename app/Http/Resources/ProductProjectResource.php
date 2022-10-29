<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'variation_id' => $this->variation_id,
            'variation' => VariationResource::make($this->variation),
            'product_id' => $this->product_id,
            'product' => ProductBasicResource::make($this->product),
            'quantity' => $this->quantity,
        ];
    }
}
