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
        'id' => 'integer',
        'parent_id' => 'integer',
        'active' => 'boolean',
    ];

    public static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return CategoryFactory::new();
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
