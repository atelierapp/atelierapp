<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductTrendingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->product->title,
            'image' => $this->product->featured_media->url,
            'favorites' => $this->favorites,
            'projects' => $this->projects,
        ];
    }
}
