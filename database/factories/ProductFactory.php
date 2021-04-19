<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
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
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'manufacturer_type' => 'store',
            'manufactured_at' => $this->faker->date(),
            'description' => $this->faker->text,
            'category_id' => Category::factory()->create()->id,
            'price' => $this->faker->randomNumber(),
            'quantity' => $this->faker->randomNumber(),
            'sku' => $this->faker->lexify('???????????'),
            'store_id' => Store::factory()->create()->id,
            'active' => $this->faker->boolean,
            'properties' => [],
        ];
    }
}
