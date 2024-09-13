<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransaksiTransferController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware'=>'api'], function ($routes) {
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/update-token', [AuthController::class, 'updateToken']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('/transfer', [TransaksiTransferController::class, 'createTransfer']);
});
