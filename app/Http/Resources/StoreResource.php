<?php

namespace App\Http\Resources;

use App\Models\Store;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Store */
class StoreResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'story' => $this->story,
            'logo' => $this->logo,
            'cover' => $this->cover,
            'team' => $this->team,
            'active' => $this->active,
            'customer_rating' => $this->customer_rating,
            'internal_rating' => $this->internal_rating,
            'qualities' => QualityResource::collection($this->whenLoaded('qualities')),
            'connected' => $this->has_active_store,
            'vendor_mode' => $this->vendor_mode,
        ];
    }
}
