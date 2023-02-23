<?php

namespace Database\Factories;

use App\Enums\ManufacturerProcessEnum;
use App\Models\Product;
use App\Models\Store;
use App\Models\Style;
use Database\Factories\Traits\ActiveState;
use Database\Factories\Traits\CountryStateTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    use ActiveState;
    use CountryStateTrait;

    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'country' => config('app.country'),
            'title' => $this->faker->text(100),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'manufactured_at' => $this->faker->date(),
            'description' => $this->faker->paragraph(),
            'score' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(10000, 90000) / 100,
            'store_id' => Store::factory(),
            'style_id' => Style::factory(),
            'quantity' => $this->faker->numberBetween(0, 100),
            'sku' => $this->faker->isbn10,
            'active' => $this->faker->boolean,
            'properties' => json_encode([]),
            'url' => $this->faker->url,
            'is_on_demand' => $this->faker->boolean,
            'is_unique' => $this->faker->boolean,
    public function activeStore()
    {
        return $this->state(function (array $attributes) {
            return [
                'store_id' => Store::factory()->active(),
            ];
        });
    }
}
