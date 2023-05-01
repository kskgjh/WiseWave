<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        $category = Category::where('type', 'children')
                        ->orderByRaw('RAND()')
                        ->first();

        $variant = Variant::orderByRaw('RAND()')
                    ->first();

        return [
            'name'=> $this->faker->unique->word(),
            'status'=> $this->faker->boolean(50),
            'text'=> $this->faker->text(255),
            'amount'=> $this->faker->randomNumber(),
            'sales'=> $this->faker->randomNumber(),
            'price'=> $this->faker->randomNumber(5),
            'category_id'=> $category->id,
            'variant_id'=> $variant->id,
        ];
    }
}
