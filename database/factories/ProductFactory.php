<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Brand;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        'description' => fake()->paragraph(1),
        'long_description' => fake()->paragraph(10),
        'nutritional_description' => fake()->paragraph(10),
        'guide_description' => fake()->paragraph(10),
        'annotation' => fake()->paragraph(1),
        'relevance' => fake()->numberBetween(0, 100),
        'category_id' => Category::all()->random()->id,
        'brand_id' => Brand::all()->random()->id
        ];
    }
}
