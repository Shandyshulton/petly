<?php

namespace Database\Seeders;

use App\Models\PetType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PetType::create([
            'pet_type_name' => 'dog'
        ]);
        PetType::create([
            'pet_type_name' => 'cat'
        ]);
        PetType::create([
            'pet_type_name' => 'rabbit'
        ]);
        PetType::create([
            'pet_type_name' => 'turtle'
        ]);
    }
}
