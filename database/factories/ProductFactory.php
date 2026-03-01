<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $name = fake()->words(5, true);

        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'price' => fake()->numberBetween(100000, 5000000),
            'stock' => fake()->numberBetween(1, 100),
            'description' => fake()->text(),
            'is_active' => fake()->boolean()
        ];
    }
}
