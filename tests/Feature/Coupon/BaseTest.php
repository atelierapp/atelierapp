<?php

namespace Tests\Feature\Coupon;

use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    use AdditionalAssertions;

    public static function structure(): array
    {
        return [
            'id',
            'is_active',
            'name',
            'code',
            'description',
            'mode',
            'mode_desc',
            'start_date',
            'end_date',
            'is_fixed',
            'amount',
            'stock',
            'current_uses',
        ];
    }
}
