<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PetController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\TransactionController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'show']);
    Route::post('/profile/update-user', [UserController::class, 'update']);

    Route::prefix('admin')->middleware(['req' => "App\Http\Middleware\CheckRole:admin"])->group(function () {
        Route::post('/add-products', [ProductController::class, 'store']);
        Route::get('/transaction', [TransactionController::class, 'indexAll']);
        Route::get('/get-all-user', [UserController::class, 'indexAll']);
        Route::delete('/delete-user/{user}', [UserController::class, 'destroy']);
    });

    Route::prefix('customer')->middleware(['req' => "App\Http\Middleware\CheckRole:customer"])->group(function () {
        Route::apiResource('/pets', PetController::class);
        Route::apiResource('/transaction', TransactionController::class);
        Route::get('/transaction/{id}', [TransactionController::class, 'show']);
        Route::post('/transaction-update', [TransactionController::class, 'update']);
        Route::post('/payment', [PaymentController::class, 'store']);
        Route::apiResource('/cart', CartController::class);
    });

    Route::prefix('courier')->middleware(['req' => "App\Http\Middleware\CheckRole:courier"])->group(function () {
        Route::post('/delivery', [DeliveryController::class, 'update']);
        Route::get('/delivery_courier', [DeliveryController::class, 'indexCourierNow']);
        Route::get('/delivery_unknown', [DeliveryController::class, 'indexGetCourierNull']);
        Route::get('/transaction-progress', [TransactionController::class, 'indexWithStatusProgress']);
    });

    Route::apiResource('/roles', RoleController::class);
});

Route::apiResource('/products', ProductController::class);