<?php

use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DropdownController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified'], 'as' => 'admin.'], function () {

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::resource('users', UserController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
    Route::resource('clients', ClientsController::class);

    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('system', [SettingController::class, 'systemSettingView'])->name('systems');
        Route::post('system', [SettingController::class, 'updateSettings'])->name('systems.update');
        Route::post('update/env', [SettingController::class, 'envKeyUpdate'])->name('systems.env.update');
    });


    Route::post('fetch-states', [DropdownController::class, 'fetchState'])->name('fetch.states');
    Route::post('fetch-cities', [DropdownController::class, 'fetchCity'])->name('fetch.cities');


});
