<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'employee'], function () {
        Route::post('/', [EmployeeController::class, 'store']);
    });
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

