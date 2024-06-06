<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\ArticleStyleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\CountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DropdownController;
use App\Http\Controllers\Admin\DyeingController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\FabricContructionController;
use App\Http\Controllers\Admin\FiberController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\KnittingController;
use App\Http\Controllers\Admin\MillController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentTermsController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\PreProductionPlanController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\RangeController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TermsOfDeliveryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\YarnPurchaseOrderController;
use App\Http\Controllers\ProcessController;
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

        Route::resource('suppliers', SupplierController::class);
        Route::get('suppliers/{id}/delete', [SupplierController::class, 'destroy']);

        Route::resource('items', ItemController::class);
        Route::get('items/{id}/delete', [ItemController::class, 'destroy']);
        Route::post('items/bulk/upload', [ItemController::class, 'bulkUpload'])->name('items.bulk.upload');

        Route::resource('category', CategoryController::class);
        Route::get('category/{id}/delete', [CategoryController::class, 'destroy']);

        Route::resource('purchase_order', PurchaseOrderController::class);

        Route::resource('clients', ClientsController::class);
        Route::get('clients/{user}/delete', [ClientsController::class, 'destroy']);
        Route::get('clients/{user}/generate_credentials', [ClientsController::class, 'generateCredentials']);

        Route::resource('range', RangeController::class);
        Route::get('range/{range}/delete', [RangeController::class, 'destroy']);

        Route::resource('fabric_construction', FabricContructionController::class);
        Route::get('fabric_construction/{range}/delete', [FabricContructionController::class, 'destroy']);

        Route::resource('payment_terms', PaymentTermsController::class);
        Route::get('payment_terms/{range}/delete', [PaymentTermsController::class, 'destroy']);

        Route::resource('article', ArticleStyleController::class);
        Route::get('article/{range}/delete', [ArticleStyleController::class, 'destroy']);

        Route::resource('jobs', JobController::class);
        Route::get('jobs/{range}/delete', [JobController::class, 'destroy']);

        Route::resource('orders', OrderController::class);
        Route::get('orders/{order}/delete', [OrderController::class, 'destroy']);

        Route::resource('pre_production_plans', PreProductionPlanController::class);
        Route::get('pre_production_plans/{pre_production_plan}/delete', [PreProductionPlanController::class, 'destroy']);

        Route::resource('count', CountController::class);
        Route::get('count/{count}/delete', [CountController::class, 'destroy']);

        Route::resource('fiber', FiberController::class);
        Route::get('fiber/{fiber}/delete', [FiberController::class, 'destroy']);

        Route::resource('mill', MillController::class);
        Route::get('mill/{mill}/delete', [MillController::class, 'destroy']);

        Route::resource('terms_of_delivery', TermsOfDeliveryController::class);
        Route::get('terms_of_delivery/{terms_of_delivery}/delete', [TermsOfDeliveryController::class, 'destroy']);

        Route::resource('yarn_purchase_order', YarnPurchaseOrderController::class);
        Route::get('yarn_purchase_order/{yarn_purchase_order}/delete', [YarnPurchaseOrderController::class, 'destroy']);

        Route::resource('agents', AgentController::class);
        Route::get('agents/{agent}/delete', [AgentController::class, 'destroy']);

        Route::resource('processes', ProcessController::class);
        Route::get('processes/{process}/delete', [ProcessController::class, 'destroy'])->name('processes.destroy');

        Route::resource('knitting', KnittingController::class);
        Route::get('knitting/{knitting}/delete', [KnittingController::class, 'destroy']);

        Route::resource('dyeing', DyeingController::class);
        Route::get('dyeing/{dyeing}/delete', [DyeingController::class, 'destroy']);

    });

});
