<?php

namespace App\Http\Resources;

use App\Enums\ManufacturerTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'manufacturer_type_code' => $this->manufacturer_type,
            'manufacturer_type' => ManufacturerTypeEnum::MAP_VALUE[$this->manufacturer_type],
            'manufactured_at' => $this->manufactured_at->toDateString(),
            'description' => $this->description,
            'price' => $this->price,
            'style_id' => $this->style_id,
            'style' => $this->style->name,
            'quantity' => $this->quantity,
            'sku' => $this->sku,
            'active' => (boolean) $this->active,
            'properties' => $this->properties,
            'featured_media' => $this->featured_media->url,
            'medias' => MediaIndexResource::collection($this->whenLoaded('medias')),
            'tags' => TagIndexResource::collection($this->whenLoaded('tags')),
            'categories' => CategoryIndexResource::collection($this->whenLoaded('categories')),
        ];
    }

}
