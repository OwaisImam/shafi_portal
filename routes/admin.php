<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DropdownController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\PreProductionPlanController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Departments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified'], 'as' => 'admin.'], function () {

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [UserController::class, 'showProfile'])->name('profile');

    Route::resource('users', UserController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
    Route::resource('clients', ClientsController::class);
    Route::get('clients/{user}/delete', [ClientsController::class, 'destroy']);
    Route::get('clients/{user}/generate_credentials', [ClientsController::class, 'generateCredentials']);
    Route::resource('email_templates', EmailTemplateController::class);
    Route::resource('departments', DepartmentController::class);
    Route::get('departments/{department}/delete', [DepartmentController::class, 'destroy']);

    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('system', [SettingController::class, 'systemSettingView'])->name('systems');
        Route::post('system', [SettingController::class, 'updateSettings'])->name('systems.update');
        Route::post('update/env', [SettingController::class, 'envKeyUpdate'])->name('systems.env.update');
    });


    Route::post('fetch-states', [DropdownController::class, 'fetchState'])->name('fetch.states');
    Route::post('fetch-cities', [DropdownController::class, 'fetchCity'])->name('fetch.cities');

    Route::group(['prefix' => 'department/{slug}', 'as' => 'departments.'], function () {
        Route::get('/dashboard', [DepartmentController::class, 'dashboard'])->name('dashboard');
        Route::resource('pre_production_plans', PreProductionPlanController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::get('suppliers/{id}/delete', [SupplierController::class, 'destroy']);
        Route::resource('items', ItemController::class);
        Route::get('items/{id}/delete', [ItemController::class, 'destroy']);
        Route::post('items/bulk/upload', [ItemController::class, 'bulkUpload'])->name('items.bulk.upload');
        Route::resource('category', CategoryController::class);
        Route::get('category/{id}/delete', [CategoryController::class, 'destroy']);
    });

});