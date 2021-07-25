<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IncomingMessageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MessageStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
   Route::view('/dashboard', 'dashboard')->name('dashboard');
   Route::resource('messages', MessageController::class);
   Route::resource('customers', CustomerController::class);
});

//Route::middleware('twilio')->group(function() {
//    Route::post('/status', [MessageStatusController::class, 'store']);
//});


Route::post('/sms/incoming', [IncomingMessageController::class, 'store']);
Route::post('/sms/status', [MessageStatusController::class, 'store']);
