<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserTestsController;
use App\Http\Controllers\Api\TestUsersController;
use App\Http\Controllers\Api\PermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('users', UserController::class);

        // User Tests
        Route::get('/users/{user}/tests', [
            UserTestsController::class,
            'index',
        ])->name('users.tests.index');
        Route::post('/users/{user}/tests/{test}', [
            UserTestsController::class,
            'store',
        ])->name('users.tests.store');
        Route::delete('/users/{user}/tests/{test}', [
            UserTestsController::class,
            'destroy',
        ])->name('users.tests.destroy');

        Route::apiResource('tests', TestController::class);

        // Test Users
        Route::get('/tests/{test}/users', [
            TestUsersController::class,
            'index',
        ])->name('tests.users.index');
        Route::post('/tests/{test}/users/{user}', [
            TestUsersController::class,
            'store',
        ])->name('tests.users.store');
        Route::delete('/tests/{test}/users/{user}', [
            TestUsersController::class,
            'destroy',
        ])->name('tests.users.destroy');
    });
