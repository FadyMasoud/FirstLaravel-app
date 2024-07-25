<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'images' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'speed' => $this->faker->numberBetween(100, 200),
            'type' => $this->faker->word,
            'cylinder' => $this->faker->word,
            'color' => $this->faker->colorName,
            'brand' => $this->faker->company,
            'model' => $this->faker->word,
            'offer' => $this->faker->randomFloat(2, 1, 100),
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
