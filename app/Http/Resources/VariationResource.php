<?php

namespace App\Http\Resources;

use App\Models\Variation;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Variation */
class VariationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => $this->country,
            'medias' => MediaResource::collection($this->whenLoaded('medias')),
            'product' => ProductResource::make($this->whenLoaded('product')),
        ];
    }
}
