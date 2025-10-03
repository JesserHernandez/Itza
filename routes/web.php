<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RoleMiddleware;


$redirectByRole = fn($user) => redirect()->route($user->is_vendor === 1 ? 'admin' : 'customer');


Route::get('/', fn () => Inertia::render('LandingPage'));

Route::get('/register', fn(Request $request) => Auth::check() ? $redirectByRole(Auth::user()) : Inertia::render('Auth/Register', ['is_vendor' => $request->query('is_vendor', false)]))->name('register');

Route::get('/login', fn() => Auth::check() ? $redirectByRole(Auth::user()) : Inertia::render('Auth/RegisterType'))->name('login');

Route::get('/register_type', fn() => Auth::check() ? $redirectByRole(Auth::user()) : Inertia::render('Auth/RegisterType'))->name('register_type');

Route::get('/dashboard', fn() => Auth::check() ? $redirectByRole(Auth::user()) : redirect()->route('/'))->name('dashboard');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', RoleMiddleware::class.':true'])->group(function () {
    //Admin
    Route::get('/admin', fn() => Inertia::render('Vendor/Index'))->name('admin');
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
    //Coupon
    Route::resource('/coupons', \App\Http\Controllers\CouponController::class);
    //Order
    Route::resource('/orders', \App\Http\Controllers\OrderController::class);
    //OrderReturn
    Route::resource('/order_returns', \App\Http\Controllers\OrderReturnController::class);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', RoleMiddleware::class.':false'])->group(function () {
    //Customer
    Route::get('/customer', fn() => Inertia::render('Customer/Index'))->name('customer');
    //PaymentMethodUser
    Route::resource('/payment_methods_users', \App\Http\Controllers\PaymentMethodUserController::class);
    //AddresseUser
    Route::resource('/addresses_users', \App\Http\Controllers\AddresseUserController::class);
    //RewardUser
    Route::resource('/rewards_users', \App\Http\Controllers\RewardUserController::class);
    //Review
    Route::resource('/reviews', \App\Http\Controllers\ReviewController::class);
    //ResponseReview
    Route::resource('/review_responses', \App\Http\Controllers\ReviewResponseController::class);
     //LikeUser
    Route::resource('/like_users', \App\Http\Controllers\LikeUserController::class);
    //Wishlist
    Route::resource('/wishlists', \App\Http\Controllers\WishlistController::class);
    //Post
    Route::resource('/posts', \App\Http\Controllers\PostController::class);
    //Report
    Route::resource('/reports', \App\Http\Controllers\ReportController::class);
    //Cart
    Route::resource('/carts', \App\Http\Controllers\CartController::class);
    //CouponUser
    Route::resource('/coupon_users', \App\Http\Controllers\CouponUserController::class);
});
