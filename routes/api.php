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

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [UserController::class, 'show']);
    Route::post('/profile/update-user', [UserController::class, 'update']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')
        ->middleware(['req' => "App\Http\Middleware\CheckRole:admin"])
        ->name('api.admin.')
        ->group(function () {
            Route::post('/add-products', [ProductController::class, 'store'])
                ->name('products.store');

            Route::get('/transaction', [TransactionController::class, 'indexAll'])
                ->name('transactions.index');

            Route::get('/get-all-user', [UserController::class, 'indexAll'])
                ->name('users.index');

            Route::delete('/delete-user/{user}', [UserController::class, 'destroy'])
                ->name('users.destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER
    |--------------------------------------------------------------------------
    */
    Route::prefix('customer')
    ->middleware(['req' => "App\Http\Middleware\CheckRole:customer"])
    ->name('api.customer.')
    ->group(function () {

        Route::apiResource('/pets', PetController::class);

        Route::apiResource('/transaction', TransactionController::class);

        // Route::post('/transaction-update', [TransactionController::class, 'update'])
        //     ->name('transaction.update');

        Route::post('/payment', [PaymentController::class, 'store'])
            ->name('payment.store');

        Route::apiResource('/cart', CartController::class)
            ->names('cart');
    });

    /*
    |--------------------------------------------------------------------------
    | COURIER
    |--------------------------------------------------------------------------
    */
    Route::prefix('courier')
        ->middleware(['req' => "App\Http\Middleware\CheckRole:courier"])
        ->name('api.courier.')
        ->group(function () {
            Route::post('/delivery', [DeliveryController::class, 'update'])
                ->name('delivery.update');

            Route::get('/delivery_courier', [DeliveryController::class, 'indexCourierNow'])
                ->name('delivery.current');

            Route::get('/delivery_unknown', [DeliveryController::class, 'indexGetCourierNull'])
                ->name('delivery.unassigned');

            Route::get('/transaction-progress', [TransactionController::class, 'indexWithStatusProgress'])
                ->name('transaction.progress');
        });

    /*
    |--------------------------------------------------------------------------
    | ROLES
    |--------------------------------------------------------------------------
    */
    Route::apiResource('/roles', RoleController::class)
        ->names('api.roles');
});

/*
|--------------------------------------------------------------------------
| PUBLIC PRODUCTS
|--------------------------------------------------------------------------
*/
Route::apiResource('/products', ProductController::class)
    ->names('api.products');
