<?php

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return RoomFactory::new();
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
