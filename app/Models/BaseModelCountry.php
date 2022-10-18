<?php

namespace App\Models;

use App\Models\Scopes\CountryScope;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBaseModelCountry
 */
class BaseModelCountry extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new CountryScope());
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->country)) {
                $model->country = config('app.country');
            }
        });
    }
}
