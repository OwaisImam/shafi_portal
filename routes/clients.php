<?php

use App\Http\Controllers\Auth\Client\AuthController;
use App\Http\Controllers\Auth\Client\ForgotPasswordController;
use App\Http\Controllers\Auth\Client\ResetPasswordController;
use App\Http\Controllers\Client\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'client.'], function () {


    Auth::routes(['verify' => true]);

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');

    // Show the password reset request form
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

    // Handle the password reset request
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Show the password reset form
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

    // Handle the password reset request
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::group(['middleware' => 'client.auth'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::post('client/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


        Route::post('/update-profile/{id}', [AuthController::class, 'updateProfile'])->name('updateProfile');
        Route::post('/update-password/{id}', [AuthController::class, 'updatePassword'])->name('updatePassword');

    });

});