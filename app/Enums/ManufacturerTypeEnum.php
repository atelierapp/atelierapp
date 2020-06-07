<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self store()
 * @method static self employee()
 * @method static self external()
 */
final class ManufacturerTypeEnum extends Enum
{
    const MAP_VALUE = [
        'store' => 'store',
        'employee' => 'employee',
        'external' => 'external',
    ];
}
