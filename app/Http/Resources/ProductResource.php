<?php

namespace App\Http\Resources;

use App\Enums\ManufacturerProcessEnum;
use App\Enums\ManufacturerTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'manufacturer_type_code' => $this->manufacturer_type,
            'manufacturer_process' => ManufacturerProcessEnum::MAP_VALUE[$this->manufacturer_process],
            'manufactured_at' => optional($this->manufactured_at)->toDateString(),
            'description' => $this->description,
            'price' => $this->price / 100,
            'style_id' => $this->style_id,
            'style' => $this->style->name,
            'quantity' => $this->quantity,
            'sku' => $this->sku,
            'active' => (boolean) $this->active,
            'properties' => $this->properties,
            'url' => $this->url,
            'featured_media' => $this->featured_media->url,
            'is_on_demand' => $this->is_on_demand,
            'is_unique' => $this->is_unique,
            'is_favorite' =>  request()->user('sanctum') ? $this->authFavorite?->exists : false,
            'qualities' => QualityResource::collection($this->whenLoaded('qualities')),
            'store' => new StoreResource($this->whenLoaded('store')),
            'medias' => MediaResource::collection($this->whenLoaded('medias')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'materials' => TagResource::collection($this->whenLoaded('materials')),
            'collections' => CollectionResource::collection($this->whenLoaded('collections')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'variations' => VariationResource::collection($this->whenLoaded('variations')),
        ];
    }
}
