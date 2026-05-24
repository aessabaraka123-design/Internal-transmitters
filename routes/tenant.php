<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\UserController;

Route::get('/login', [LoginController::class, 'showTenantLogin'])->name('tenant.login');
Route::post('/login', [LoginController::class, 'tenantLogin'])->name('tenant.login.post');
Route::post('/logout', [LoginController::class, 'tenantLogout'])->name('tenant.logout');

Route::middleware(['auth', 'tenant.active'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');

    Route::middleware('role:admin')->prefix('users')->name('tenant.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});