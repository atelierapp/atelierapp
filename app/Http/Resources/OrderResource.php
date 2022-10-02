<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => UserSimpleResource::make($this->user),
            'seller_id' => $this->seller_id,
            'seller' => UserSimpleResource::make($this->seller),
            'items' => $this->items,
            'total_price' => $this->total_price,
            'seller_status' => $this->seller_status,
            'seller_status_at' => $this->seller_status_at,
            'paid_status' => $this->paid_status,
            'paid_on' => $this->paid_on,
        ];
    }
}
