<?php

use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitViolationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViolationController;
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
        //auth required
        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::get('user', 'getUser');
            //admin
            Route::group(['middleware' => ['role:admin']], function () {
                Route::get('users', 'users');
                Route::get('set-user-active/{user}', 'setUserActive');
                Route::get('set-user-block/{user}', 'setUserBlock');
                Route::put('users/{user}', 'update');
                Route::delete('users/{user}', 'destroy');
            });
            //all
            Route::post('change-my-password', 'changeMyPassword');
        });
    });
    //auth required
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //admin
        Route::group(['middleware' => ['role:admin']], function () {
            Route::post('set-unit-officer', [UnitController::class, 'setUnitOfficer']);
            Route::controller(UnitController::class)->group(function () {
                Route::get('units/', 'index');
                Route::post('units/', 'store');
                Route::put('units/{unit}', 'update');
                Route::delete('units/{unit}', 'destroy');
            });
            Route::resource('violations', ViolationController::class)->except(['show', 'edit', 'index']);
            Route::get('unit-violations', [UnitViolationController::class, 'index']);
        });
        Route::get('violations', [ViolationController::class, 'index']);
        //all
        Route::get('units/{unit}', [UnitController::class, 'show'])->middleware(['can:عرض المخالفات']);
        Route::middleware(['have.unit'])->group(function () {
            Route::post('unit-violations', [UnitViolationController::class, 'store'])->middleware(['can:تسجيل المخالفات']);
            Route::put('unit-violations/{id}', [UnitViolationController::class, 'update'])->middleware(['can:تعديل المخالفات']);
            Route::delete('unit-violations/{id}', [UnitViolationController::class, 'destroy'])->middleware(['can:حذف المخالفات']);
        });
    });
});
