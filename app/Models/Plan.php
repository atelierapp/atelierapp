<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 * @property string $key
 * @property string $name
 * @property int $price
 * @property string|null $description
 * @property string $stripe_plan_id
 * @property string $stripe_price_id
 * @mixin IdeHelperPlan
 */
class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'price', // Stored in cents
        'description',
        'stripe_plan_id',
        'stripe_price_id',
    ];
}
