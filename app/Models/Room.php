<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dimensions',
        'doors',
        'windows',
        'framing',
    ];

    protected $casts = [
        'id' => 'integer',
        'dimensions' => 'json',
        'doors' => 'json',
        'windows' => 'json',
        'framing' => 'json',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
