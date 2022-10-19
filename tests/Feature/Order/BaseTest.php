<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\Store;
use Database\Seeders\OrderStatusSeeder;
use Tests\TestCase;

class BaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            OrderStatusSeeder::class,
            // OrderStatusSeeder::class,
        ]);
    }
}
