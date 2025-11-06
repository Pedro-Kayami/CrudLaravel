<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Admin\ColorOptionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\PublicVehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicVehicleController::class, 'index'])->name('home');
Route::get('/veiculos/{vehicle}', [PublicVehicleController::class, 'show'])->name('vehicles.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('brands', BrandController::class)->except('show');
        Route::resource('models', CarModelController::class)->except('show');
        Route::resource('colors', ColorOptionController::class)->except('show');
        Route::resource('vehicles', AdminVehicleController::class)->except('show');
    });

Route::resource('clientes', ClientesController::class);
