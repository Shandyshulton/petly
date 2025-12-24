<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductsController extends Controller
{
    public function destroy($id)
    {
        $response = Http::delete("http://petly.test:8080/api/products/{$id}");
        return back();
    }
}