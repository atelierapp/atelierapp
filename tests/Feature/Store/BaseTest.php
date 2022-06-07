<?php

namespace Tests\Feature\Store;

use Tests\TestCase;

/**
 * @title Stores
 */
abstract class BaseTest extends TestCase
{
    public static function structure(): array
    {
        return [
            'id',
            'name',
            // 'legal_name',
            // 'legal_id',
            'story',
            'logo',
            'cover',
            'team',
            'active',
        ];
    }
}
