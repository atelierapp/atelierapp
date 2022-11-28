<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $external_plan_id
 * @property string $name
 * @property string $description
 * @property string $frequency
 * @property string $currency
 * @property int|float $price
 * @property bool $active
 */
class PaypalPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_plan_id',
        'name',
        'description',
        'frequency',
        'currency',
        'price',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function price(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }
}
