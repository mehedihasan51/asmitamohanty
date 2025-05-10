<?php

use App\Http\Controllers\Api\Renter\FavoriteController;
use App\Http\Controllers\Api\Renter\ReviewController;
use App\Http\Controllers\Api\Renter\StripeWebHookBookingController;
use Illuminate\Support\Facades\Route;



Route::controller(FavoriteController::class)->prefix('product/favorite')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/toggle/{product_id}', 'toggle')->name('toggle');
});

Route::controller(ReviewController::class)->prefix('product/review')->group(function () {
    Route::post('/store/{product_id}', 'store')->name('store');
});

Route::controller(StripeWebHookBookingController::class)->prefix('product/booking')->group(function () {
    Route::post('/store', 'store')->name('store');
});



