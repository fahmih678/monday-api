<?php

use App\Http\Controllers\Web\{
    AuthController,
    CategoryController,
    MerchantController,
    MerchantProductController,
    MyMerchantController,
    ProductController,
    WarehouseController,
    OverviewController,
    RoleController,
    TransactionController,
    UserController,
    WarehouseProductController,
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'authenticate'])->name('login.post');
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
Route::middleware('auth', 'role:manager')->group(function () {
    Route::get('overview', [OverviewController::class, 'overviewManager'])->name('overview-manager');

    Route::prefix('manage-categories')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('manage-categories.index');
        Route::get('create', 'create')->name('manage-categories.create');
        Route::post('store', 'store')->name('manage-categories.store');
        Route::get('edit/{id}', 'edit')->name('manage-categories.edit');
        Route::post('update/{id}', 'update')->name('manage-categories.update');
        Route::delete('delete/{id}', 'destroy')->name('manage-categories.destroy');
    });

    Route::prefix('manage-products')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('manage-products.index');
        Route::get('create', 'create')->name('manage-products.create');
        Route::post('store', 'store')->name('manage-products.store');
        Route::get('edit/{id}', 'edit')->name('manage-products.edit');
        Route::post('update/{id}', 'update')->name('manage-products.update');
        Route::delete('delete/{id}', 'destroy')->name('manage-products.destroy');
    });

    Route::prefix('manage-warehouses')->name('manage-warehouses.')->group(function () {
        Route::controller(WarehouseController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
            Route::get('{id}', 'show')->name('show');
        });
        Route::controller(WarehouseProductController::class)->group(function () {
            Route::get('{warehouse_id}/assign-product', 'assignProduct')->name('assign-product');
            Route::post('{warehouse_id}/attach', 'attach')->name('attach-product');
            Route::get('{warehouse_id}/edit-stock/{product_id}', 'editStock')->name('edit-stock-product');
            Route::post('{warehouse_id}/edit-stock/{product_id}', 'update')->name('update-stock-product');
        });
    });

    Route::prefix('manage-merchants')->name('manage-merchants.')->group(function () {
        Route::controller(MerchantController::class)->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('{id}', 'show')->name('show');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
        });
        Route::controller(MerchantProductController::class)->group(function () {
            Route::get('{merchant_id}/assign-product', 'assignProduct')->name('assign-product');
            Route::post('{merchant_id}/attach', 'attach')->name('attach-product');
            Route::get('{merchant_id}/edit-stock/{product_id}', 'editStock')->name('edit-stock-product');
            Route::post('{merchant_id}/edit-stock/{product_id}', 'update')->name('update-stock-product');
        });
    });

    Route::prefix('manage-users')->name('manage-users.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('assign-role', 'assignRole')->name('assign-role');
        Route::post('assign-role', 'assignRoleStore')->name('assign-role.store');
    });

    Route::prefix('manage-roles')->name('manage-roles.')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create',  'create')->name('create');
        Route::post('store',  'store')->name('store');
        Route::get('edit/{id}',  'edit')->name('edit');
        Route::post('update/{id}',  'update')->name('update');
        Route::delete('delete/{id}',  'destroy')->name('destroy');
    });
});

Route::middleware('auth', 'role:keeper')->group(function () {
    Route::get('overview-keeper', [OverviewController::class, 'overviewKeeper'])->name('overview-keeper');
    Route::get('my-merchant-transactions', [TransactionController::class, 'listTransactions'])->name('my-merchant-transactions.index');
    Route::get('my-merchant-transactions/create', [TransactionController::class, 'create'])->name('my-merchant-transactions.create');

    Route::get('my-merchant-transactions/{id}', [TransactionController::class, 'show'])->name('my-merchant-transactions.show');
    Route::get('my-merchant-products', [MyMerchantController::class, 'index'])->name('my-merchant-products.index');
});
