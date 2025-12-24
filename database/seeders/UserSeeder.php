<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'role_role_id' => 3,
            'password' => 'admin1234',
            'phone_number' => '081949742576',
            'email' => 'admin@gmail.com',
        ]);

        User::create([
            'username' => 'courier',
            'role_role_id' => 2,
            'password' => 'courier1234',
            'phone_number' => '081223388991',
            'email' => 'salikinsalimin@gmail.com',
        ]);
    }
    
}
