<?php

namespace Database\Factories;

use App\Enums\ManufacturerProcessEnum;
use App\Enums\ManufacturerTypeEnum;
use App\Models\Product;
use App\Models\Store;
use App\Models\Style;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(100),
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'manufactured_at' => $this->faker->date(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 90000),
            'store_id' => Store::factory(),
            'style_id' => Style::factory(),
            'quantity' => $this->faker->numberBetween(0, 100),
            'sku' => $this->faker->isbn10,
            'active' => $this->faker->boolean,
            'properties' => json_encode([]),
            'url' => $this->faker->url,
            'is_on_demand' => $this->faker->boolean,
            'is_unique' => $this->faker->boolean,
        ];
    }
}
