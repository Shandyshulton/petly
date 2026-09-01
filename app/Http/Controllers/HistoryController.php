<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HistoryController extends Controller
{
    public function getHistory(Request $request)
    {
        $tab = in_array($request->query('tab'), ['shop', 'appointment']) ? $request->query('tab') : 'shop';
        $status = $request->query('status');

        $shopStatuses = ['pending', 'progress', 'complete', 'canceled'];
        $appointmentStatuses = ['pending', 'approved', 'completed', 'cancelled'];

        // Validasi status sesuai tab aktif
        if ($tab === 'shop') {
            $status = in_array($status, $shopStatuses) ? $status : null;
        } else {
            $status = in_array($status, $appointmentStatuses) ? $status : null;
        }

        if (!session()->has('api_token')) {
            return view('history', [
                'tab' => $tab,
                'status' => $status,
            ]);
        }

        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)
                        ->get(config('services.petly_api.url') . '/api/customer/transaction');

        $data = $response->successful() ? $response->json() : [];
        $transactions = collect($data['data'] ?? []);

        // Filter transaksi berdasarkan status
        if ($status) {
            $transactions = $transactions->filter(function ($transaction) use ($status) {
                return strtolower($transaction['transaction_status']['transaction_status_name'] ?? '') === strtolower($status);
            })->values();
        }

        $appointments = Appointment::where('user_user_id', session('user_id'))
            ->latest()
            ->get();

        // Filter appointment berdasarkan status
        if ($status) {
            $appointments = $appointments->filter(function ($appointment) use ($status) {
                return strtolower($appointment->status) === strtolower($status);
            })->values();
        }

        return view('history', [
            'tab' => $tab,
            'status' => $status,
            'transactions' => $transactions,
            'appointments' => $appointments,
        ]);
    }
}
