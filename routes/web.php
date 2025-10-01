<?php

use App\Http\Controllers\Web\{
    CategoryController,
    MerchantController,
    ProductController,
    WarehouseController,
    OverviewController,
    WarehouseProductController,
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages-starter');
});

Route::get('overview', [OverviewController::class, 'index'])->name('overview');

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
