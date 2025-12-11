<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\AuthController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    Route::prefix('system')->group(function () {
        Route::get('/users', [FinancialController::class, 'listUsers']);
        Route::get('/users/{id}', [FinancialController::class, 'userDetail']);
        Route::get('/users/{id}/accounts', [FinancialController::class, 'userAccounts']);
        Route::get('/users/{id}/financial-summary', [FinancialController::class, 'userFinancialSummary']);
        Route::get('/accounts/{accountId}/transactions', [FinancialController::class, 'accountTransactions']);
    });
});