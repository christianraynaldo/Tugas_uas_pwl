<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KonsumenController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Konsumen\AlamatController;
use App\Http\Controllers\Konsumen\AuthController;
use App\Http\Controllers\Konsumen\CartController;
use App\Http\Controllers\Konsumen\ProdukController as KonsumenProdukController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/produk/{id}', [FrontendController::class, 'show'])->name('produk.show');

// Auth Konsumen
// Konsumen custom login & register
Route::get('/konsumen/login', [AuthController::class, 'showLoginForm'])->name('konsumen.login');
Route::post('/konsumen/login', [AuthController::class, 'login']);
Route::get('/konsumen/register', [AuthController::class, 'showRegisterForm'])->name('konsumen.register');
Route::post('/konsumen/register', [AuthController::class, 'register']);
Route::post('/konsumen/logout', [AuthController::class, 'logout'])->name('konsumen.logout');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin/dashboard', [AdminAuthController::class, 'index'])->name('admin.dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('konsumen', KonsumenController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('order', OrderController::class);
    Route::get('order-export', [OrderController::class, 'export'])->name('order.export');
    Route::get('/admin/order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/admin/order/{id}/update-status', [OrderController::class, 'updateStatus'])->name('order.update-status');
});

// Dashboard Konsumen
Route::get('/dashboard', [KonsumenProdukController::class, 'index'])->name('konsumen.dashboard');

// Cart
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/showDetail/{id}', [CartController::class, 'showDetail'])->name('cart.showDetail');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/order/updatestatus/{id}', [CartController::class, 'updateStatus'])->name('cart.updateStatus');
Route::post('/order/bayar/{id}', [CartController::class, 'uploadBukti'])->name('order.uploadBukti.store');
Route::post('/cart/checkout/process', [CartController::class, 'processCheckout'])->name('cart.processCheckout');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/order', [CartController::class, 'orderKonsumen'])->name('cart.orderKonsumen');

Route::get('/cart/invoice/{id}', [CartController::class, 'exportPDF'])->middleware('auth:konsumen')->name('cart.invoice');

require __DIR__ . '/auth.php';

Route::middleware(['auth:konsumen'])->group(function () {
    Route::get('/alamat', [AlamatController::class, 'index'])->name('alamat.index');
    Route::get('/alamat/create', [AlamatController::class, 'create'])->name('alamat.create');
    Route::post('/alamat', [AlamatController::class, 'store'])->name('alamat.store');
    Route::get('/cart/showDetail/{id}', [CartController::class, 'showDetail'])->name('cart.showDetail');
    Route::get('/cart/export-pdf/{id}', [CartController::class, 'exportPdf'])->name('cart.exportPdf');
    Route::get('/cart/invoice/{id}', [CartController::class, 'exportPdf'])->name('cart.invoice');
});

Route::get('/api/provinsi', function () {
    $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
    return response()->json($response->json());
});
Route::get('/api/kota/{id}', function ($id) {
    $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$id}.json");
    return response()->json($response->json());
});

Route::get('/api/kecamatan/{id}', function ($id) {
    $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$id}.json");
    return response()->json($response->json());
});
