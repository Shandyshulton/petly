<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    public function getTransactions(Request $request)
    {
        $transactions = Transaction::with(['users', 'transactionStatus', 'transactionDetails'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('transaction_id', $search)
                        ->orWhereHas('users', fn ($query) => $query->where('username', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%"))
                        ->orWhereHas('transactionStatus', fn ($query) => $query->where('transaction_status_name', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->whereHas('transactionStatus', fn ($query) => $query->where('transaction_status_name', $request->status)))
            ->when($request->filled('date_from'), fn ($query) => $query->whereDate('transaction_date', '>=', $request->input('date_from')))
            ->when($request->filled('date_to'), fn ($query) => $query->whereDate('transaction_date', '<=', $request->input('date_to')))
            ->latest('transaction_date')
            ->paginate(12)
            ->withQueryString();

        $statuses = Transaction::query()
            ->join('transaction_statuses', 'transactions.transactions_transaction_status_id', '=', 'transaction_statuses.transaction_status_id')
            ->select('transaction_statuses.transaction_status_name')
            ->distinct()
            ->orderBy('transaction_statuses.transaction_status_name')
            ->pluck('transaction_statuses.transaction_status_name');

        return view('admin/order', [
            'transactions' => $transactions,
            'statuses' => $statuses,
            'filters' => $request->only(['q', 'status', 'date_from', 'date_to']),
        ]);
    }  
}    
