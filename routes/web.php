<?php

use App\Http\Controllers\CurrentCustomerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IncomingMessageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MessageStatusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
   Route::view('/dashboard', 'dashboard')->name('dashboard');

   Route::view('/inactive', 'inactive')->name('inactive');

   Route::group(['middleware' => 'active'], function() {

       Route::resource('messages', MessageController::class);

       Route::group(['middleware' => 'admin'], function () {
           Route::resource('customers', CustomerController::class);
           Route::resource('users', UserController::class);
       });

   });

   Route::patch('current-customer', [CurrentCustomerController::class, 'update'])->name('current-customer.update');
});

Route::post('/sms/incoming', [IncomingMessageController::class, 'store']);
Route::post('/sms/status', [MessageStatusController::class, 'store']);
