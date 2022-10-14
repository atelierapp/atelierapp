<?php

namespace Tests\Feature\Invoice;

use App\Models\Order;
use App\Services\InvoiceService;
use Tests\TestCase;

class InvoiceServiceTest extends TestCase
{
    public function test_generate_an_invoice_from_order()
    {
        $order = Order::factory()->hasDetails(3)->create();

        app(InvoiceService::class)->generateFromOrder($order);

        $this->assertDatabaseCount('invoices', 1);
        $this->assertDatabaseCount('invoice_details', 3);
    }
}
