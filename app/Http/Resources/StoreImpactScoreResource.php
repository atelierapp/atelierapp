<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreImpactScoreResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'score' => $this->internal_rating,
            'qualities' => QualityResource::collection($this->whenLoaded('qualities')),
            'files' => StoreImpactMediaResource::collection($this->whenLoaded('medias')),
        ];
    }
}
