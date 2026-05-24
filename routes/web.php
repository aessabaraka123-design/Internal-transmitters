<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Tenant\DashboardController;

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// تسجيل الدخول للسوبر أدمن
Route::prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showSuperAdminLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'superAdminLogin'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'superAdminLogout'])->name('logout');

    Route::middleware('auth:super_admin')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('tenants', TenantController::class);
        Route::post('tenants/{tenant}/toggle-status', [TenantController::class, 'toggleStatus'])->name('tenants.toggle-status');
        Route::post('tenants/{tenant}/extend-subscription', [TenantController::class, 'extendSubscription'])->name('tenants.extend-subscription');
    });
});

// تسجيل شركة جديدة
Route::get('/register', [TenantController::class, 'registerForm'])->name('register');
Route::post('/register', [TenantController::class, 'register'])->name('register.post');

// تسجيل دخول الموظفين
Route::get('/login', [LoginController::class, 'showTenantLogin'])->name('tenant.login');
Route::post('/login', [LoginController::class, 'tenantLogin'])->name('tenant.login.post');
Route::post('/logout', [LoginController::class, 'tenantLogout'])->name('tenant.logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');
});
// Messaging routes
Route::middleware('auth')->prefix('messages')->name('messaging.')->group(function () {
    Route::get('/inbox', [\Modules\Messaging\Http\Controllers\MessageController::class, 'inbox'])->name('inbox');
    Route::get('/sent', [\Modules\Messaging\Http\Controllers\MessageController::class, 'sent'])->name('sent');
    Route::get('/compose', [\Modules\Messaging\Http\Controllers\MessageController::class, 'compose'])->name('compose');
    Route::post('/send', [\Modules\Messaging\Http\Controllers\MessageController::class, 'send'])->name('send');
    Route::get('/conversation/{user}', [\Modules\Messaging\Http\Controllers\MessageController::class, 'conversation'])->name('conversation');
    Route::delete('/{message}', [\Modules\Messaging\Http\Controllers\MessageController::class, 'destroy'])->name('destroy');
});
Route::get('/tenant-files/{path}', function ($path) {
    $fullPath = storage_path('app/tenant/' . $path);
    if (!file_exists($fullPath)) abort(404);
    return response()->file($fullPath);
})->where('path', '.*')->middleware('auth');