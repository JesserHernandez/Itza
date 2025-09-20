<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use LDAP\Result;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //Dashboard
    Route::get('/dashboard', function () { return Inertia::render('Dashboard'); })->name('dashboard');
    //PaymentMethodUser
    Route::resource('/payment_methods_users', \App\Http\Controllers\PaymentMethodUserController::class);
    //AddresseUser
    Route::resource('/addresses_users', \App\Http\Controllers\AddresseUserController::class);
    //RewardUser
    Route::resource('/rewards_users', \App\Http\Controllers\RewardUserController::class);
    //VerificationUser
    Route::resource('/verification_users', \App\Http\Controllers\VerificationUserController::class);
    //Category
    Route::resource('/categories', \App\Http\Controllers\CategoryController::class);
    //ProductMaterial
    Route::resource('/product_materials', \App\Http\Controllers\ProductMaterialController::class);
    //Tag
    Route::resource('/tags', \App\Http\Controllers\TagController::class);
     //Product
    Route::resource('/products', \App\Http\Controllers\ProductController::class);
    //Inventory
    Route::resource('/inventories', \App\Http\Controllers\InventoryController::class);
    //Movement
    Route::resource('/movements', \App\Http\Controllers\MovementController::class);
    //Cart
    Route::resource('/carts', \App\Http\Controllers\CartController::class);
    //Coupon
    Route::resource('/coupons', \App\Http\Controllers\CouponController::class);
    //CouponUser
    Route::resource('/coupon-users', \App\Http\Controllers\CouponUserController::class);
    //Order
    Route::resource('/orders', \App\Http\Controllers\OrderController::class);
    //OrderReturn
    Route::resource('/order_returns', \App\Http\Controllers\OrderReturnController::class);
    //Review
    Route::resource('/reviews', \App\Http\Controllers\ReviewController::class);
    //ResponseReview
    Route::resource('/respondes_reviews', \App\Http\Controllers\ResponseReviewController::class);
     //LikeUser
    Route::resource('/like_users', \App\Http\Controllers\LikeUserController::class);
    //Wishlist
    Route::resource('/wishlists', \App\Http\Controllers\WishlistController::class);
    //Post
    Route::resource('/posts', \App\Http\Controllers\PostController::class);
    //Report
    Route::resource('/reports', \App\Http\Controllers\ReportController::class);
});
