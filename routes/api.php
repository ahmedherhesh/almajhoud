<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1'], function () {

    Route::get('login', function () {
        return response()->json(['msg' => 'Unauthorized!'], 403);
    })->name('login');

    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register'])->name('register');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['middleware' => ['role:admin', 'api']], function () {
            Route::get('users', [UserController::class, 'index']);
        });
        Route::post('change-my-password', [UserController::class, 'changeMyPassword']);
    });
});
