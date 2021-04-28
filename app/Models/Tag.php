<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'active',
        'taggable_type',
        'taggable_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
    ];

    public function products(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }

    public function projects(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Project::class, 'taggable');
    }

}
