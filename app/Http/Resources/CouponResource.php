<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'is_active' => (boolean) $this->is_active,

            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'mode' => $this->mode,
            'mode_desc' => $this->mode_description,
            'start_date' => $this->start_date->toDateString(),
            'end_date' => $this->end_date->toDateString(),
            'is_fixed' => (boolean) $this->is_fixed,
            'amount' => $this->amount,
            'stock' => $this->max_uses,
            'current_uses' => $this->current_uses,
        ];

    }
}
