<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'title' => $this->title,
            'manufacturer_type' => $this->manufacturer_type,
            'manufactured_at' => $this->manufactured_at,
            'description' => $this->description,
            'price' => number_format($this->price / 100, 2),
            'quantity' => $this->quantity,
            'sku' => $this->sku,
            'active' => $this->active,
            'properties' => $this->properties,
            'featured_media' => $this->featured_media->url,
            'medias' => MediaResource::collection($this->medias),
            'tags' => TagResource::collection($this->tags),
            'style' => optional($this->style)->name,
            'categories' => Category::collection($this->categories),
        ];
    }
}
