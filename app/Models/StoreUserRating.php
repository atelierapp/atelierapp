<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperStoreUserQualify
 */
class StoreUserRating extends Model
{
    use HasFactory;

    protected $table = 'store_user_ratings';

    protected $fillable = [
        'user_id',
        'store_id',
        'score',
        'comment',
    ];
}
