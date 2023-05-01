<?php

namespace Database\Seeders;

use App\Models\Variant;
use App\Models\variantOptions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Variant::factory(5)
            ->has(variantOptions::factory(4))
            ->create();
    }
}
