<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\productImg;
use Illuminate\Database\Seeder;

class productImgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        productImg::factory(30)
            ->for(Product::class)
            ->create();
    }
}
