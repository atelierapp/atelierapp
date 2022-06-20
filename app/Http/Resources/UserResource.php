<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
            'birthday' => $this->birthday ? $this->birthday->format('m/d/Y') : null,
            'avatar' => $this->avatar,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->format('m/d/Y H:i:s'),
            'updated_at' => $this->updated_at->format('m/d/Y H:i:s'),
        ];
    }
}
