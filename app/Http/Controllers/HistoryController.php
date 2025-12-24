<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HistoryController extends Controller
{
    public function getHistory()
    {
        if (!session()->has('api_token')) {
            return view('history');
        }
        
        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)
                        ->get('http://petly.test:8080/api/customer/transaction');
        
        $data = $response->json();
        
        return view('history', [
            'transactions' => $data['data'] ?? [],
        ]);
    }
}

