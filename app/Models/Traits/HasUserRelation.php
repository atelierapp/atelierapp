<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUserRelation
{

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
