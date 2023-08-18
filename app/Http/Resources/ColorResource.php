<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
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
            'name' => $this->title,
            'hex' => strtoupper($this->properties['hex']),
            'url' => $this->featured_media->url,
            'active' => $this->active,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

    // Todo :: temporally commented
    // public function toArray($request)
    // {
    //     return [
    //         'id' => $this->id,
    //         'name' => $this->name,
    //         'hex' => $this->hex,
    //         'url' => $this->url,
    //         'active' => $this->active,
    //         'created_at' => $this->created_at->toDateTimeString(),
    //         'updated_at' => $this->updated_at->toDateTimeString(),
    //     ];
    // }
}
