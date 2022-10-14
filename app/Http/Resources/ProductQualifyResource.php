<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductQualifyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user' => UserSimpleResource::make($this->user),
            'product' => ProductBasicResource::make($this->product),
            'score' => $this->score,
            'comment' => $this->comment,
            'attaches' => ProductQualifyFileResource::collection($this->whenLoaded('files')),
        ];
    }
}
