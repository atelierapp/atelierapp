<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceDetailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'product_id' => Product::factory(),
            'variation_id' => Variation::factory(),
            'unit_price' => $this->faker->numberBetween(10000, 50000) / 100,
            'quantity' => $this->faker->numberBetween(1,5),
            'total_price' => $this->faker->numberBetween(10000, 50000) / 100,
        ];
    }
}
