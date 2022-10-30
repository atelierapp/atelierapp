<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->resource->name,
            'uuid' => $this->resource->uuid,
            'user_id' => $this->resource->user_id,
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
