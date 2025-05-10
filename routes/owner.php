<?php

use App\Http\Controllers\Api\Owner\ImageController;
use App\Http\Controllers\Api\Owner\PackageController;
use App\Http\Controllers\Api\Owner\ProductController;
use Illuminate\Support\Facades\Route;

//start product controllers
Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(ImageController::class)->prefix('product/image')->name('product.image.')->group(function () {
    Route::get('/{product_id}', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
});

Route::controller(PackageController::class)->prefix('product/package')->name('product.package.')->group(function () {
    Route::get('/{product_id}', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});
//end product controllers