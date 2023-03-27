<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\productImg;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(40)
            ->has(productImg::factory()->count(2))
            ->create();
    }
}
