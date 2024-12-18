<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CurrentCustomerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IncomingMessageController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\MessageArchiveController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MessageStatusController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::view('/inactive', 'inactive')->name('inactive');

    Route::middleware('active')->group(function () {

        Route::resource('messages', MessageController::class);

        Route::middleware('admin')->group(function () {
            Route::resource('customers', CustomerController::class);
            Route::resource('users', UserController::class);
        });

        Route::resource('archive', MessageArchiveController::class);
        Route::resource('contacts', ContactController::class);
        Route::resource('lists', ListController::class);
        Route::resource('tags', TagController::class);
        Route::resource('templates', TemplateController::class);
    });

    Route::patch('current-customer', [CurrentCustomerController::class, 'update'])->name('current-customer.update');
});

Route::post('/sms/incoming', [IncomingMessageController::class, 'store']);
Route::post('/sms/status', [MessageStatusController::class, 'store']);
