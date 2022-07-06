<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreUserQualifyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'score' => $this->score,
            'comment' => $this->comment,
        ];
    }
}
