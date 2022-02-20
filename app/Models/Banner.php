<?php

namespace App\Models;

use App\Traits\Models\HasMediasRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    use HasMediasRelation;

    public const TYPE_POPUP = 'popup';
    public const TYPE_CAROUSEL = 'carousel';

    protected $fillable = [
        'name',
        'order',
        'segment',
        'type',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'order' => 'integer',
        'segment' => 'string',
        'type' => 'string',
    ];

}
