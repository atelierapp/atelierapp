<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreIndexResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'legal_name' => $this->legal_name,
            'legal_id' => $this->legal_id,
            'story' => $this->story,
            'logo' => $this->logo,
            'cover' => $this->cover,
            'team' => $this->team,
            'active' => (boolean) $this->active,
        ];
    }
}
