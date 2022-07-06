<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreUserQualify extends Model
{
    use HasFactory;

    protected $table = 'store_user_qualifies';

    protected $fillable = [
        'user_id',
        'store_id',
        'score',
        'comment',
    ];
}
