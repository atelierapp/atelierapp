<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'legal_name' => $this->legal_name,
            'legal_id' => $this->legal_id,
            'story' => $this->story,
            'logo' => $this->logo,
            'cover' => $this->cover,
            'team' => $this->team,
            'active' => $this->active,
        ];
    }
}
