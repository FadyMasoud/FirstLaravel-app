<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pd_name' => $this->faker->word,
            'name' => $this->faker->word,
            'images' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'speed' => $this->faker->number
        ];
    }
}
