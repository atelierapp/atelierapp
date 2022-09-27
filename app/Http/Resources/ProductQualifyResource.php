<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductQualifyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'product_id' => $this->product_id,
            'score' => $this->score,
            'comment' => $this->comment,
            'attaches' => ProductQualifyFileResource::collection($this->whenLoaded('files')),
        ];
    }
}
