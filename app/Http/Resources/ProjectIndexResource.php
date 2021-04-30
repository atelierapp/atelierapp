<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectIndexResource extends JsonResource
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
            'style' => $this->style->name,
            'author' => $this->author->full_name,
            'published' => (boolean) $this->published,
            'public' => (boolean) $this->public,
        ];
    }

}
