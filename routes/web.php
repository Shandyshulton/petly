<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AddProductController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\AppointmentManagementController;
use App\Http\Controllers\CourierController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $response = Http::get(config('services.petly_api.url') . '/api/products');
    return view('home', ['products' => $response]);
})->name('home');

Route::get('/aboutus', fn () => view('aboutus'))->name('about');
Route::get('/services', [AppointmentController::class, 'create'])->name('services');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/pet', fn () => view('pet'))->name('pet');
Route::get('/theme', fn () => view('theme'))->name('theme');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// Portal login admin
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login.process');

// Portal login courier
Route::get('/courier/login', [LoginController::class, 'showCourierLoginForm'])->name('courier.login');
Route::post('/courier/login', [LoginController::class, 'courierLogin'])->name('courier.login.process');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.process');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/logout', [LogoutController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| PRODUCT
|--------------------------------------------------------------------------
*/

Route::get('/product', function () {
    $response = Http::get(config('services.petly_api.url') . '/api/products');
    return view('product', ['products' => $response]);
})->name('product.index');

Route::get('/detailproduct/{id}', function ($id) {
    $response = Http::get(config('services.petly_api.url') . "/api/products/{$id}");
    return view('detailproduct', [
        'product' => $response->json()['data']
    ]);
})->name('product.show');

/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

Route::post('/cart', [ProductCartController::class, 'store'])->name('cart.add');
Route::get('/cart', [CartsController::class, 'index'])->name('cart.index');
Route::delete('/cart/{id}', [CartsController::class, 'destroy'])->name('cart.destroy');

/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'storeCheckout'])->name('checkout.store');
Route::post('/checkout/update-address', [CheckoutController::class, 'updateAddress'])->name('checkout.update-address');
Route::post('/checkout/update-shipping', [CheckoutController::class, 'updateShipping'])->name('checkout.update-shipping');
Route::post('/checkout/update-payment', [CheckoutController::class, 'updatePaymentMethod'])->name('checkout.update-payment');
Route::post('/checkout/process-payment', [CheckoutController::class, 'storePayment'])->name('checkout.payment');
Route::post('/checkout/resume', [CheckoutController::class, 'resumeCheckout'])->name('checkout.resume');
Route::post('/checkout/cancel-payment', [CheckoutController::class, 'finish'])->name('checkout.cancel');

/*
|--------------------------------------------------------------------------
| PROFILE & HISTORY
|--------------------------------------------------------------------------
*/

Route::get('/profile', [ProfileController::class, 'getProfile'])->name('profile');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/profile/address', [ProfileController::class, 'addressIndex'])->name('profile.address');
Route::post('/profile/address', [ProfileController::class, 'addressStore'])->name('profile.address.store');
Route::get('/profile/address/{address}/edit', [ProfileController::class, 'addressEdit'])->name('profile.address.edit');
Route::put('/profile/address/{address}', [ProfileController::class, 'addressUpdate'])->name('profile.address.update');
Route::post('/profile/address/{address}/active', [ProfileController::class, 'addressSetActive'])->name('profile.address.set-active');
Route::delete('/profile/address/{address}', [ProfileController::class, 'addressDestroy'])->name('profile.address.destroy');

Route::get('/history', [HistoryController::class, 'getHistory'])->name('history');

/*
|--------------------------------------------------------------------------
| ADMIN (dilindungi middleware 'admin' berbasis session role_id = 3)
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->group(function () {

    /*
    |----------------------------------------------------------------------
    | ADMIN PRODUCT
    |----------------------------------------------------------------------
    */

    // LIST PRODUCT
    Route::get('/admin/product', [AdminProductController::class, 'index'])
        ->name('admin.product.index');

    // ADD PRODUCT (FORM)
    Route::get('/admin/product/add', [AddProductController::class, 'showForm'])
        ->name('admin.product.add');

    // STORE PRODUCT
    Route::post('/admin/product/add', [AddProductController::class, 'store'])
        ->name('admin.product.store');

    Route::get('/admin/product/{product}/edit', [ProductsController::class, 'edit'])
        ->name('admin.product.edit');

    Route::put('/admin/product/{product}', [ProductsController::class, 'update'])
        ->name('admin.product.update');

    // DELETE PRODUCT (PALING BAWAH)
    Route::delete('/admin/product/{product}', [ProductsController::class, 'destroy'])
        ->name('admin.product.destroy');

    /*
    |----------------------------------------------------------------------
    | ADMIN USER
    |----------------------------------------------------------------------
    */

    Route::get('/admin/user', [UserManagementController::class, 'show'])
        ->name('admin.user.index');

    Route::get('/admin/user/{id}/edit-courier', [UserManagementController::class, 'editCourier'])
        ->name('admin.user.edit-courier');

    Route::put('/admin/user/{id}/edit-courier', [UserManagementController::class, 'updateCourier'])
        ->name('admin.user.update-courier');

    Route::delete('/admin/user/{id}', [UserManagementController::class, 'destroy'])
        ->name('admin.user.destroy');

    Route::get('/admin/profile', [AdminProfileController::class, 'edit'])
        ->name('admin.profile.edit');

    Route::put('/admin/profile', [AdminProfileController::class, 'update'])
        ->name('admin.profile.update');

    Route::get('/admin/theme', [AdminProfileController::class, 'theme'])
        ->name('admin.theme');

    /*
    |----------------------------------------------------------------------
    | ADMIN ORDER
    |----------------------------------------------------------------------
    */

    Route::get('/admin/order', [OrderManagementController::class, 'getTransactions'])
        ->name('admin.order.index');

    /*
    |----------------------------------------------------------------------
    | ADMIN APPOINTMENT
    |----------------------------------------------------------------------
    */

    Route::get('/admin/appointment', [AppointmentManagementController::class, 'index'])
        ->name('admin.appointment.index');

    Route::patch('/admin/appointment/{appointment}', [AppointmentManagementController::class, 'updateStatus'])
        ->name('admin.appointment.update');
});


/*
|--------------------------------------------------------------------------
| COURIER
|--------------------------------------------------------------------------
*/

Route::get('/courier/courier-info', [CourierController::class, 'getDelivery'])->name('courier.info');
Route::post('/courier/courier-info', [CourierController::class, 'updateProfile'])->name('courier.profile.update');
Route::post('/courier/photo', [CourierController::class, 'updatePhoto'])->name('courier.photo.update');
Route::get('/courier/theme', fn () => view('courier.theme'))->name('courier.theme');
Route::get('/courier/parcel-tracking', [CourierController::class, 'getCourier'])->name('courier.tracking');
Route::post('/courier/parcel-tracking', [CourierController::class, 'finish'])->name('courier.finish');
