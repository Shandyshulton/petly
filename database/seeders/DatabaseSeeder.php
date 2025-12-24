<?php

namespace Database\Seeders;

use App\Models\DeliveryClass;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // ProductSeeder::class,
        $this->call([
            RoleSeeder::class, 
            UserSeeder::class,
            PetTypeSeeder::class, 
            DeliveryClassSeeder::class, 
            ProductTypeSeeder::class, 
            ProductSeeder::class,
            PaymentMethodSeeder::class,
            TransactionStatusSeeder::class
        ]);
        // User::factory(5)->recycle([Role::all()])->create();
    }
}
