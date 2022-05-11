<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'medias' => MediaResource::collection($this->whenLoaded('medias')),
        ];
    }
}
