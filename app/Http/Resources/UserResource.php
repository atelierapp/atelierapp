<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource {

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'birthday'   => $this->birthdat ? $this->birthday->format('m/d/Y') : null,
            'avatar'     => $this->avatar,
            'is_active'  => $this->is_active,
            'created_at' => $this->created_at->format('m/d/Y H:i:s'),
            'updated_at' => $this->updated_at->format('m/d/Y H:i:s'),
        ];
    }
}
