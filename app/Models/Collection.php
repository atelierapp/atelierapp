<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'collectionable');
    }
}
