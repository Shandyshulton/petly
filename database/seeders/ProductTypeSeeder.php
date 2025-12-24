<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductType::create([
            'product_type_name' => 'food',
        ]);
        ProductType::create([
            'product_type_name' => 'accesories',
        ]);
        ProductType::create([
            'product_type_name' => 'medicine',
        ]);
    }
}
