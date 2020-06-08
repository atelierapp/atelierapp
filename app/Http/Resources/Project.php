<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Project extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'style_id' => $this->resource->style_id,
            'author_id' => $this->resource->author_id,
            'forked_from' => $this->resource->forked_from,
            'published' => (boolean) $this->resource->published,
            'public' => (boolean) $this->resource->public,
        ];
    }
}
