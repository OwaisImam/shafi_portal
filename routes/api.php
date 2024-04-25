<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forget-password', [AuthController::class, 'forgetPass']);
    Route::post('/reset-password', [AuthController::class, 'resetPass']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'verified']], function () {
    Route::get('clients/list', [APIController::class, 'listClients']);
    Route::post('clients/store', [APIController::class, 'storeClients']);

    Route::group(['prefix' => 'users', 'middleware' => ['role:Super Admin']], function () {
        Route::get('list', [UserController::class, 'index']);
    });

});