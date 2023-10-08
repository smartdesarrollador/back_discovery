<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Variation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductFeatures>
 */
class ProductFeaturesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => fake()->word(),
        'value' => fake()->numberBetween(0, 200),
        'variation_id' => Variation::all()->random()->id
        ];
    }
}
