<?php

namespace App\Models;

use App\Models\Builders\ProductViewBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProductView
 */
class ProductView extends Model
{
    use HasFactory;

    protected $table = 'product_views';

    protected $fillable = [
        'product_id',
        'user_id',
        'created_at'
    ];

    public $timestamps = false;

    public function newEloquentBuilder($query): ProductViewBuilder
    {
        return new ProductViewBuilder($query);
    }
}
