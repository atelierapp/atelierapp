<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self handmade()
 * @method static self single_production()
 * @method static self community_made()
 * @method static self artisan_made()
 * @method static self vintage()
 */
final class ManufacturerProcessEnum extends Enum
{
    public const MAP_VALUE = [
        'handmade' => 'Handmade',
        'single_production' => 'Single Production',
        'community_made' => 'Community Made',
        'artisan_made' => 'Artisan Made',
        'vintage' => 'Vintage',
    ];

    public const MAP_VALUE_ES = [
        'handmade' => 'Hecho a mano',
        'single_production' => 'Producción única',
        'community_made' => 'Hecho por la comunidad',
        'artisan_made' => 'Hecho artesanalmente',
        'vintage' => 'Antiguo',
    ];
}
