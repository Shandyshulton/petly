<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $response = Http::get("http://petly.test:8080/api/products");
    return view('home', ['products' => $response]);
})->name('home');

Route::get('/aboutus', fn () => view('aboutus'))->name('about');
Route::get('/services', fn () => view('services'))->name('services');
Route::get('/bank', fn () => view('bank'))->name('bank');
Route::get('/pet', fn () => view('pet'))->name('pet');
Route::get('/theme', fn () => view('theme'))->name('theme');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.process');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| PRODUCT
|--------------------------------------------------------------------------
*/

Route::get('/product', function () {
    $response = Http::get("http://petly.test:8080/api/products");
    return view('product', ['products' => $response]);
})->name('product.index');

Route::get('/detailproduct/{id}', function ($id) {
    $response = Http::get("http://petly.test:8080/api/products/{$id}");
    return view('detailproduct', [
        'product' => $response->json()['data']
    ]);
})->name('product.show');

/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\CartsController;

Route::post('/cart', [ProductCartController::class, 'store'])->name('cart.add');
Route::get('/cart', [CartsController::class, 'index'])->name('cart.index');
Route::delete('/cart/{id}', [CartsController::class, 'destroy'])->name('cart.destroy');

/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\CheckoutController;

Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'storeCheckout'])->name('checkout.store');
Route::post('/checkout/update-shipping', [CheckoutController::class, 'updateShipping'])->name('checkout.update-shipping');
Route::post('/checkout/update-payment', [CheckoutController::class, 'updatePaymentMethod'])->name('checkout.update-payment');
Route::post('/checkout/process-payment', [CheckoutController::class, 'storePayment'])->name('checkout.payment');
Route::post('/checkout/cancel-payment', [CheckoutController::class, 'finish'])->name('checkout.cancel');

/*
|--------------------------------------------------------------------------
| PROFILE & HISTORY
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;

Route::get('/profile', [ProfileController::class, 'getProfile'])->name('profile');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/history', [HistoryController::class, 'getHistory'])->name('history');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AddProductController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\OrderManagementController;

/*
|--------------------------------------------------------------------------
| ADMIN PRODUCT
|--------------------------------------------------------------------------
*/

// LIST PRODUCT
Route::get('/admin/product', function () {
    $response = Http::get("http://petly.test:8080/api/products");
    return view('admin.product', ['products' => $response]);
})->name('admin.product.index');

// ADD PRODUCT (FORM)
Route::get('/admin/product/add', [AddProductController::class, 'showForm'])
    ->name('admin.product.add');

// STORE PRODUCT
Route::post('/admin/product/add', [AddProductController::class, 'store'])
    ->name('admin.product.store');

// DELETE PRODUCT (PALING BAWAH)
Route::delete('/admin/product/{product}', [ProductsController::class, 'destroy'])
    ->name('admin.product.destroy');

/*
|--------------------------------------------------------------------------
| ADMIN USER
|--------------------------------------------------------------------------
*/

Route::get('/admin/user', [UserManagementController::class, 'show'])
    ->name('admin.user.index');

Route::delete('/admin/user/{id}', [UserManagementController::class, 'destroy'])
    ->name('admin.user.destroy');

/*
|--------------------------------------------------------------------------
| ADMIN ORDER
|--------------------------------------------------------------------------
*/

Route::get('/admin/order', [OrderManagementController::class, 'getTransactions'])
    ->name('admin.order.index');


/*
|--------------------------------------------------------------------------
| COURIER
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\CourierController;

Route::get('/courier/courier-info', [CourierController::class, 'getDelivery'])->name('courier.info');
Route::get('/courier/parcel-tracking', [CourierController::class, 'getCourier'])->name('courier.tracking');
Route::post('/courier/parcel-tracking', [CourierController::class, 'finish'])->name('courier.finish');
