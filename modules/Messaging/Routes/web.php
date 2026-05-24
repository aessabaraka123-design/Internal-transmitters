<?php

use Illuminate\Support\Facades\Route;
use Modules\Messaging\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| مسارات وحدة المراسلات
| تعمل داخل سياق الشركة (Tenant)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'tenant.active'])->prefix('messages')->name('messaging.')->group(function () {

    Route::get('/inbox',          [MessageController::class, 'inbox'])->name('inbox');
    Route::get('/sent',           [MessageController::class, 'sent'])->name('sent');
    Route::get('/compose',        [MessageController::class, 'compose'])->name('compose');
    Route::post('/send',          [MessageController::class, 'send'])->name('send');
    Route::get('/conversation/{user}', [MessageController::class, 'conversation'])->name('conversation');
    Route::delete('/{message}',   [MessageController::class, 'destroy'])->name('destroy');

});
