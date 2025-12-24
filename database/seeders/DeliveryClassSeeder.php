<?php

namespace Database\Seeders;

use App\Models\DeliveryClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryClass::create([
            'delivery_class_price' => 5000,
            'delivery_class_name' => 'Standard',
            'delivery_class_desc' => 'Estimasi sampai 2 - 4 hari'
        ]);
        
        DeliveryClass::create([
            'delivery_class_price' => 7000,
            'delivery_class_name' => 'Ekspress',
            'delivery_class_desc' => 'Estimasi sampai 1 - 2 hari'
        ]);
    }
}
