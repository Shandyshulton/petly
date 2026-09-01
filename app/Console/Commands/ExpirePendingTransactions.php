<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ExpirePendingTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:expire-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batalkan transaksi pending yang berumur lebih dari 15 menit';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Ambil daftar user yang punya token (agar bisa memanggil API per user)
        $users = \App\Models\User::whereNotNull('token')->get();

        $now = now();
        $expiredCount = 0;

        foreach ($users as $user) {
            try {
                $response = Http::withToken($user->token)
                    ->get(config('services.petly_api.url') . '/api/customer/transaction');

                if (!$response->successful()) {
                    continue;
                }

                $transactions = collect($response->json('data') ?? []);

                foreach ($transactions as $t) {
                    $status = strtolower($t['transaction_status']['transaction_status_name'] ?? '');

                    if ($status !== 'pending') {
                        continue;
                    }

                    $createdAt = Carbon::parse($t['transaction_date'] ?? null);

                    if (!$createdAt->isPast()) {
                        continue;
                    }

                    // Batalkan jika sudah lebih dari 15 menit
                    if ($createdAt->diffInMinutes($now) >= 15) {
                        Http::withToken($user->token)->post(
                            config('services.petly_api.url') . '/api/customer/transaction-update',
                            [
                                'transaction_id' => $t['transaction_id'],
                                'status_name' => 'canceled',
                            ]
                        );

                        $expiredCount++;
                        $this->info("Transaksi #{$t['transaction_id']} dibatalkan (melebihi 15 menit).");
                    }
                }
            } catch (\Throwable $e) {
                $this->error("Gagal proses user #{$user->user_id}: {$e->getMessage()}");
            }
        }

        $this->info("Selesai. {$expiredCount} transaksi pending kedaluwarsa dibatalkan.");

        return self::SUCCESS;
    }
}
