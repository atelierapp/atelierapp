<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QualityStoreRequest extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => ['re']
        ];
    }
}
