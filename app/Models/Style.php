<?php

namespace App\Models;

use Database\Factories\StyleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Nova\Fields\BelongsToMany;

class Style extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
