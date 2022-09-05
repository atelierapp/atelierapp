<?php

namespace App\Traits\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUserRelation
{

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
