<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

$redirectByRole = function (Collection $roles) {
    if ($roles->isEmpty()) {
        return redirect()->route('landingPage');
    }

    return match ($roles->first()) {
        'Administrador' => redirect()->route('administrator'),
        'Vendedor'      => redirect()->route('vendor'),
        'Cliente'       => redirect()->route('customer'),
        default         => redirect()->route('landingPage'),
    };
};

Route::redirect('/', '/landingPage');

Route::get('/landingPage', fn () => Inertia::render('LandingPage'))->name('landingPage');

Route::get('/register', fn(Request $request) => Auth::check() ? $redirectByRole(Auth::user()->getRoleNames()) : Inertia::render('Auth/Register', ['is_vendor' => $request->query('is_vendor', false)]))->name('register');

Route::get('/login', fn() => Auth::check() ? $redirectByRole(Auth::user()->getRoleNames()) : Inertia::render('Auth/Login'))->name('login');

Route::get('/dashboard', fn() => Auth::check() ? $redirectByRole(Auth::user()->getRoleNames()) : redirect()->route('/landingPage'))->name('dashboard');

Route::get('/card_cities', fn() => Inertia::render('CardCities'))->name('card_cities');

Route::get('/sjo', fn() => Inertia::render('SJO'))->name('sjo');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:Administrador'])->group(function () {
    //Administrator
    Route::get('/administrator', fn() => Inertia::render('Administrator/Index'))->name('administrator');
    //Users
    Route::resource('/users', \App\Http\Controllers\UserController::class);
    //Roles
    Route::resource('/roles', \App\Http\Controllers\RoleController::class);
    //Permissions
    Route::resource('/permissions', \App\Http\Controllers\PermissionController::class);
    //CreativeCities
    Route::resource('creative_cities', \App\Http\Controllers\CreativeCityController::class);
    //CreativeCircuit
    Route::resource('creative_circuits', \App\Http\Controllers\CreativeCircuitController::class);
    //TransportService
    Route::resource('transport_services', \App\Http\Controllers\TransportServiceController::class);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:Vendedor|Administrador'])->group(function () {
    //Vendor
    Route::get('/vendor', fn() => Inertia::render('Vendor/Index'))->name('vendor');
    //Category
    Route::resource('/categories', \App\Http\Controllers\CategoryController::class);
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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:Cliente|Administrador'])->group(function () {
    //Customer
    Route::get('/customer', fn() => Inertia::render('Customer/Index'))->name('customer');
    //PaymentMethodUser
    Route::resource('/user_payment_methods', \App\Http\Controllers\UserPaymentMethodController::class);
    //AddresseUser
    Route::resource('/user_addresses', \App\Http\Controllers\UserAddresseController::class);
    //RewardUser
    Route::resource('/user_rewards', \App\Http\Controllers\UserRewardController::class);
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
