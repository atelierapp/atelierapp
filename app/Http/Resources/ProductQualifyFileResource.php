<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductQualifyFileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'url' => Storage::disk('s3')->url($this->url),
        ];
    }
}
