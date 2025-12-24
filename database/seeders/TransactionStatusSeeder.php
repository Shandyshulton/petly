<?php

namespace Database\Seeders;

use App\Models\TransactionStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransactionStatus::create([
            'transaction_status_name' => 'complete',
        ]);
        TransactionStatus::create([
            'transaction_status_name' => 'progress',
        ]);
        TransactionStatus::create([
            'transaction_status_name' => 'pending',
        ]);
        TransactionStatus::create([
            'transaction_status_name' => 'canceled',
        ]);
    }
}
