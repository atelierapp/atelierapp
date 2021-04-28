<?php

namespace Database\Factories;

use App\Enums\ManufacturerTypeEnum;
use App\Models\Product;
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
            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufactured_at' => $this->faker->date(),
            'description' => $this->faker->text,
            'style_id' => 1,
            'price' => $this->faker->numberBetween(0, 90000),
            'quantity' => $this->faker->numberBetween(0, 100),
            'sku' => $this->faker->isbn10,
            'active' => $this->faker->boolean,
            'properties' => null,
        ];
    }
}
