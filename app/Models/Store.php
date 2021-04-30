<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'legal_name',
        'legal_id',
        'story',
        'logo',
        'cover',
        'team',
        'active',
    ];

    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
    ];

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function scopeSearch($query, $value)
    {
        if (empty($value)) {
            return $query;
        }

        return $query
            ->where('name', 'like', "%{$value}%")
            ->orWhere('legal_name', 'like', "%{$value}%")
            ->orWhere('team', 'like', "%{$value}%");
    }

}
