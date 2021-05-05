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
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'style_id' => $this->style_id,
            'style' => $this->style->name,
            'author_id' => $this->author_id,
            'author' => $this->author->full_name,
            'published' => $this->published,
            'public' => $this->public,
            'created_at' => $this->created_at->toDatetimeString(),
            'updated_at' => $this->updated_at->toDatetimeString(),
            'forkedFrom' => self::make($this->whenLoaded('forkedFrom'))
        ];
    }

}
