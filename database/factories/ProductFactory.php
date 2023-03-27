<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        return [
            'name'=> $this->faker->unique()->word(),
            'status'=> $this->faker->boolean(50),
            'text'=> $this->faker->text(255),
            'amount'=> $this->faker->randomNumber(),
        ];
    }
}
