<?php

use App\Http\Controllers\MessageStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])->group(function() {
   Route::view('/dashboard', 'dashboard')->name('dashboard');

});

Route::post('/status', [MessageStatusController::class, 'store']);
