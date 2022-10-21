<?php

namespace App\Http\Resources;

use App\Enums\ManufacturerProcessEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductBasicResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'score' => $this->score,
            'price' => (double) $this->price,
            'sku' => $this->sku,
            'active' => (boolean) $this->active,
            'featured_media' => $this->featured_media->url,
        ];
    }
}
