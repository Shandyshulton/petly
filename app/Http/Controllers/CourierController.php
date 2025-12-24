<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourierController extends Controller
{
    public function getCourier()
    {
        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)
                    ->get('http://petly.test:8080/api/courier/delivery_unknown');
        
        $data = $response->json();
        return view('/courier/parcelTracking', [
            'couriers' => $data['data'] ?? [],
        ]);
    }  

    public function finish(Request $request)
    {
        $apiToken = session('api_token');
        $courierID = session('user_id');
        Http::withToken($apiToken)
            ->post('http://petly.test:8080/api/courier/delivery', [
                'courier_id' => $courierID,
                'delivery_id' => $request->delivery_id,
            ]);

        return back()->with('success');
    }

    public function getDelivery()
    {
        $apiToken = session('api_token');
        $response = Http::withToken($apiToken)
                    ->get('http://petly.test:8080/api/courier/delivery_courier');
        
        $data = $response->json();
        return view('/courier/courierInfo', [
            'couriers' => $data['data'] ?? [],
        ]);
    }  
}    

