<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreImpactMediaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'quality_id' => $this->extra['quality_id'],
            'orientation' => $this->orientation,
            'url' => $this->url,
        ];
    }
}
