<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\productImg;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\productImg>
 */
class productImgFactory extends Factory
{
    protected $model = productImg::class;

    public function definition(): array
    {

        return [
            'name'=> $this->faker->imageUrl(),
        ];
    }
}
