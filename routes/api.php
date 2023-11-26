<?php

use App\Http\Controllers\UnitController;
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
    //User Controller
    Route::controller(UserController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register')->name('register');
        Route::group(['middleware' => ['auth:sanctum']], function () {
            //admin
            Route::group(['middleware' => ['role:admin']], function () {
                Route::get('users', 'index');
                Route::put('users/{user}', 'update');
                Route::delete('users/{user}', 'destroy');
                Route::get('set-user-active/{user}', 'setUserActive');
                Route::get('set-user-block/{user}', 'setUserBlock');
            });
            //all
            Route::post('change-my-password', 'changeMyPassword');
        });
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {
        //admin
        Route::group(['middleware' => ['role:admin']], function () {
            Route::post('set-unit-officer', [UnitController::class, 'setUnitOfficer']);
        });
    });
});
