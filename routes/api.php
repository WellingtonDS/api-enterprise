<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CompanyController;

Route::group(['prefix' => 'v1'], function () {
    Route::post('/user/store', [UserController::class, 'store']);
    Route::get('/user/show/{login}', [UserController::class, 'show']);
    Route::post('/user/update', [UserController::class, 'update']);
    Route::post('/user/delete/{login}', [UserController::class, 'delete']);

    Route::post('/expense/store', [ExpenseController::class, 'store']);
    Route::get('/expense/show', [ExpenseController::class, 'show']);
    Route::post('/expense/update', [ExpenseController::class, 'update']);
    Route::delete('/expense/delete', [ExpenseController::class, 'delete']);
    
    Route::post('/company/store', [CompanyController::class, 'store']);
    Route::post('/company/show', [CompanyController::class, 'show']);
    Route::post('/company/update', [CompanyController::class, 'update']);
    Route::delete('/company/delete', [CompanyController::class, 'delete']);
});