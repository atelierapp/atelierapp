<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'parent_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public static function newFactory()
    {
        return CategoryFactory::new();
    }

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }

    public function categories()
    {
        return $this->hasMany(\App\Models\Category::class);
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
