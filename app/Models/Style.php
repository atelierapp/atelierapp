<?php

namespace App\Models;

use Database\Factories\StyleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function newFactory()
    {
        return StyleFactory::new();
    }
}
