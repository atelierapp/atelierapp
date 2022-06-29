<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'style_id' => $this->style_id,
            'style' => $this->whenLoaded('style', StyleResource::make($this->style)),
            'author_id' => $this->author_id,
            'author' => $this->whenLoaded('author', UserResource::make($this->author)),
            'published' => $this->published,
            'public' => $this->public,
            'image' => $this->featured_media->url,
            'created_at' => $this->created_at->toDatetimeString(),
            'updated_at' => $this->updated_at->toDatetimeString(),
            'forkedFrom' => self::make($this->whenLoaded('forkedFrom')),
            'tags' => $this->whenLoaded('tags', TagResource::collection($this->tags)),
            'settings' => $this->settings,
        ];
    }
}
