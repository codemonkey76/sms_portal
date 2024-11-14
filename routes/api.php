<?php

use App\Http\Controllers\Api\MessageStatsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // Old API
    Route::post('message_stats', MessageStatsController::class)->name('api.message_stats');

    // New API
    Route::post('messages/get_stats', [MessageStatsController::class, 'getStats'])->name('api.messages.get_stats');
    Route::post('messages/set_imported', [MessageStatsController::class, 'setImported'])->name('api.messages.set_imported');
});
