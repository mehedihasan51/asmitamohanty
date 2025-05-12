<?php

use App\Http\Controllers\Api\Auth\BlockController;
use App\Http\Controllers\Api\Auth\ChangePasswordController;
use App\Http\Controllers\Api\Auth\FlowController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Auth\SocialLoginController;
use App\Http\Controllers\Api\Auth\PostController as AuthPostController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\FirebaseTokenController;
use App\Http\Controllers\Api\Frontend\CategoryController;
use App\Http\Controllers\Api\Frontend\CmsController;
use App\Http\Controllers\Api\Frontend\HomeController;
use App\Http\Controllers\Api\Frontend\PostController;
use App\Http\Controllers\Api\Frontend\ProductController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\TimeZoneController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest:api'], function ($router) {
    //register
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('/verify-email', [RegisterController::class, 'VerifyEmail']);
    Route::post('/resend-otp', [RegisterController::class, 'ResendOtp']);
    Route::post('/verify-otp', [RegisterController::class, 'VerifyEmail']);
    //login
    Route::post('login', [LoginController::class, 'login'])->name('login');
    //forgot password
    Route::post('/forget-password', [ResetPasswordController::class, 'forgotPassword']);
    Route::post('/otp-token', [ResetPasswordController::class, 'MakeOtpToken']);
    Route::post('/reset-password', [ResetPasswordController::class, 'ResetPassword']);
    //social login
    Route::post('/social-login', [SocialLoginController::class, 'SocialLogin']);

    //page
//    Route::get('/page/home', [HomeController::class, 'index']);
   
});

    Route::get('/page/home', [HomeController::class, 'index']);

Route::group(['middleware' => ['auth:api', 'otp']], function () {
    Route::get('/refresh-token', [LoginController::class, 'refreshToken']);
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::get('/me', [UserController::class, 'me']);
    Route::get('/account/switch', [UserController::class, 'accountSwitch']);
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
    Route::post('/update-avatar', [UserController::class, 'updateAvatar']);
    Route::delete('/delete-profile', [UserController::class, 'destroy']);
    Route::post('/change-password', [ChangePasswordController::class, 'changePassword']);

    Route::get('/flow', [FlowController::class, 'index']);
    Route::get('/flow/toggle/{user_id}', [FlowController::class, 'toggle']);

    Route::get('/block', [BlockController::class, 'index']);
    Route::get('/block/toggle/{user_id}', [BlockController::class, 'toggle']);
});

// Firebase Token Module
Route::middleware(['auth:api'])->controller(FirebaseTokenController::class)->prefix('firebase')->group(function () {
    Route::get("test", "test");
    Route::post("token/add", "store");
    Route::post("token/get", "getToken");
    Route::post("token/delete", "deleteToken");
});

//Notification
Route::middleware(['auth:api'])->controller(NotificationController::class)->prefix('notify')->group(function () {
    Route::get('test', 'test');
    Route::get('/', 'index');
    Route::get('status/read/all', 'readAll');
    Route::get('status/read/{id}', 'readSingle');
});


Route::get('/category', [CategoryController::class, 'index']);

Route::controller(ProductController::class)->prefix('product')->group(function () {
    Route::get('/', 'index');
    Route::get('show/{id}', 'show');
    Route::get('search', 'search');
    Route::post('filter', 'filter');
    Route::get('recommended', 'recommended');
    Route::get('recommended/all', 'recommendedAll');
    Route::get('trending', 'trending');
    Route::get('trending/all', 'trendingAll');
    Route::get('trending/rental', 'trendingRental');
    Route::get('trending/rental/all', 'trendingRentalAll');
    Route::get('latest', 'latest');
    Route::get('review/{product_id}', 'reviewIndex');

    Route::get('size', 'sizeIndex');
    Route::get('condition', 'conditionIndex');
    Route::get('clothfor', 'clothforIndex');
    Route::get('color', 'ColorIndex');
    Route::get('measurement', 'MeasurementIndex');
});

//Post
Route::middleware(['auth:api'])->controller(AuthPostController::class)->prefix('both/post')->group(function () {
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::get('/show/{id}', 'show');
    Route::post('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'destroy');

    Route::get('/like/toggle/{post_id}', 'toggle');
    
    Route::post('/comment/store', 'commentStore');
    Route::delete('/comment/delete/{comment_id}', 'commentDelete');
    Route::get('/comment/like/toggle/{comment_id}', 'commentToggle');

    Route::post('/reply/store', 'replyStore');
    Route::delete('/reply/delete/{comment_id}', 'replyDelete');
    Route::get('/reply/like/toggle/{comment_id}', 'replyToggle');
});

Route::controller(PostController::class)->prefix('post')->group(function () {
    Route::get('/', 'index');
    Route::get('/show/{id}', 'show');
});

//cms
Route::controller(CmsController::class)->prefix('cms/')->group(function () {
    Route::get('terms', 'term');
    Route::get('privacies', 'privacy');
    Route::get('homes', 'home');
    Route::get('abouts', 'about');
});

//chat
Route::middleware(['auth:api'])->controller(ChatController::class)->prefix('both/chat')->group(function () {
    Route::get('/list', 'list');
    Route::post('/send/{receiver_id}', 'send');
    Route::get('/conversation/{receiver_id}', 'conversation');
    Route::get('/room/{receiver_id}', 'room');
    Route::get('/search', 'search');
    Route::get('/seen/all/{receiver_id}', 'seenAll');
    Route::get('/seen/single/{chat_id}', 'seenSingle');
});

//timezone
Route::controller(TimeZoneController::class)->prefix('timezone')->group(function () {
    Route::post('/set', 'set');
    Route::get('/get', 'get');
});

