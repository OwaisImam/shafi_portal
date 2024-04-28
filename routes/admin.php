<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

// Route::group(['middleware' => 'auth', 'verified'], function () {

Route::get('/', [DashboardController::class, 'index']);
Route::get('dashboard', [DashboardController::class, 'index']);

// });
