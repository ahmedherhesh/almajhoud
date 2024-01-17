<?php

use App\Http\Controllers\UnitController;
use App\Http\Controllers\OfficerViolationController;
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
        //auth required
        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::get('user', 'getUser');
            //admin
            Route::group(['middleware' => ['role:admin']], function () {
                //create officer
                Route::post('register', 'register')->name('register')->middleware(['check.permission:اضافة الضباط']);
                Route::get('users', 'users')->middleware(['check.permission:عرض الضباط']);
                Route::put('users/{user}', 'update')->middleware(['check.permission:تعديل الضباط']);
                Route::delete('users/{user}', 'destroy')->middleware(['check.permission:حذف الضباط']);
                Route::get('permissions', 'permissions');
            });
            //all
            Route::post('change-my-password', 'changeMyPassword');
        });
    });
    //auth required
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //admin
        Route::group(['middleware' => ['role:admin']], function () {
            //violations crud
            Route::controller(ViolationController::class)->group(function () {
                Route::post('violations', 'store')->middleware(['check.permission:اضافة عناوين المخالفات']);
                Route::put('violations/{violation}', 'update')->middleware(['check.permission:تعديل عناوين المخالفات']);
                Route::delete('violations/{violation}', 'destroy')->middleware(['check.permission:حذف عناوين المخالفات']);
            });
            // Total unit violations
            Route::get('unit-violations', [OfficerViolationController::class, 'index'])->middleware(['check.permission:عرض اجمالي المخالفات']);
        });
        Route::get('violations', [ViolationController::class, 'index'])->middleware(['check.permission:عرض عناوين المخالفات']);
        //all
        Route::middleware(['have.unit'])->group(function () {
            // One unit violations
            Route::get('users/{user}', [OfficerViolationController::class, 'show'])->middleware(['check.permission:عرض مخالفات']);
            Route::post('officer-violations', [OfficerViolationController::class, 'store'])->middleware(['check.permission:اضافة مخالفات']);
            Route::put('officer-violations/{id}', [OfficerViolationController::class, 'update'])->middleware(['check.permission:تعديل مخالفات']);
            Route::delete('officer-violations/{id}', [OfficerViolationController::class, 'destroy'])->middleware(['check.permission:حذف مخالفات']);
        });
    });
});
