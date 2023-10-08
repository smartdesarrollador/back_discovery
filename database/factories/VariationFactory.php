<?php

namespace Database\Factories;

use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variation>
 */
class VariationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::all()->random()->id,
        /* 'attribute_id' => Attribute::all()->random()->id, */
        'short_attribute_name' => fake()->randomElement(['10 kg', '20 kg', 'bolsa 5 kg', 'Envase 500 ml']),
        'price' => fake()->randomFloat(2, 0, 500),
        'stock' => fake()->numberBetween(0, 20)
        ];
    }
}
