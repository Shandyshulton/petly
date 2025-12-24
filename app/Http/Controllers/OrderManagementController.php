<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderManagementController extends Controller
{
    public function getTransactions()
    {
        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)
        ->get('http://petly.test:8080/api/admin/transaction');
        
        $data = $response->json();
        return view('admin/order', [
            'transactions' => $data['data'] ?? [],
        ]);
    }  
}    
