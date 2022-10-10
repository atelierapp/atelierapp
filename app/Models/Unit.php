<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperUnit
 */
class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'class',
        'factor',
        'unit_system_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'factor' => 'float',
        'unit_system_id' => 'integer',
    ];

    public function unitSystem(): BelongsTo
    {
        return $this->belongsTo(\App\Models\UnitSystem::class);
    }
}
