<?php

use App\Http\Controllers\Web\{
    CategoryController,
    MerchantController,
    ProductController,
    WarehouseController,
    OverviewController,
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages-starter');
});

Route::get('/overview',[OverviewController::class, 'index']);
Route::get('/categories',[CategoryController::class, 'index']);
Route::get('/products',[ProductController::class, 'index']);
Route::get('/warehouses',[WarehouseController::class, 'index']);
Route::get('/merchants',[MerchantController::class, 'index']);