<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'image_url' => $this->featured_media->url,
            'order' => $this->order,
            'segment' => $this->segment,
            'type' => $this->type,
        ];
    }
}
