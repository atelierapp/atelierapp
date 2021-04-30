<?php

namespace App\Http\Resources;

use App\Enums\ManufacturerTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductIndexResource extends JsonResource
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
            'title' => $this->title,
            'manufacturer_type_code' => $this->manufacturer_type,
            'manufacturer_type' => ManufacturerTypeEnum::MAP_VALUE[$this->manufacturer_type],
            'manufactured_at' => $this->manufactured_at->toDateString(),
            'description' => $this->description,
            'price' => number_format($this->price / 100, 2),
            'style_id' => $this->style_id,
            'style' => $this->style->name,
            'quantity' => $this->quantity,
            'sku' => $this->sku,
            'active' => (boolean) $this->active,
        ];
    }

}
