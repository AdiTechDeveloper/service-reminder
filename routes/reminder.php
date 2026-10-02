<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PushSubscriptionController;
use App\Http\Controllers\ServiceTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('clients', ClientController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('service-types', ServiceTypeController::class)->only(['index', 'store', 'destroy']);
    Route::resource('client-services', ClientServiceController::class)->except('show');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');

    Route::post('/push/subscribe', [PushSubscriptionController::class, 'store'])->name('push.subscribe');
});
