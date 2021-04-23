<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'style_id' => $this->style_id,
            'author_id' => $this->author_id,
            'forked_from' => $this->forked_from,
            'published' => $this->published,
            'public' => $this->public,
        ];
    }
}
