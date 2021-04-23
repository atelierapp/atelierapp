<?php

namespace App\Models;

use Database\Factories\UnitSystemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitSystem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'unit_systems';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return UnitSystemFactory::new();
    }

    public function units(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Unit::class);
    }
}
