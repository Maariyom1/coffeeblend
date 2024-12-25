<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Products\CartController;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
// use App\Http\Controllers\Admin\LoginController;
// use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Middleware\CheckCartNotEmpty;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\LanguageController;
use App\Http\Middleware\LocaleMiddleware;
use App\Http\Controllers\StripeController;

// Default route to welcome view
Route::get('/',[HomeController::class, 'default']);

// Route::get('/dashboard', function() {
//     return view('home');
// });

// Authentication routes
Auth::routes();

// Home route
Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::get('/home', [HomeController::class, 'productOrders'])
    ->name('products.index');

// Admin routes starts
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::get('logout', [AdminLoginController::class, 'logout'])->name('logout');

    Route::get('register', [AdminRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AdminRegisterController::class, 'register']);

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });
    Route::get('/users', [AdminController::class, 'adminUsers'])->name('users');
    Route::get('/settings', [AdminController::class, 'adminSettings'])->name('settings');
    Route::get('/profile', [AdminController::class, 'adminProfile'])->name('profile');
    Route::get('/orders', [AdminController::class, 'adminOrders'])->name('orders');
    Route::get('/orders/index', [AdminController::class, 'adminOrders'])->name('orders.index');
    Route::get('/orders/export', [AdminController::class, 'exportOrders'])->name('orders.export');
    Route::get('/orders/edit/{id}', [AdminController::class, 'editOrders'])->name('orders.edit');
    Route::put('/orders/{id}', [AdminController::class, 'updateOrders'])->name('orders.update');
    Route::get('/bookings', [AdminController::class, 'adminBookings'])->name('bookings');
    Route::get('/products', [AdminController::class, 'adminProducts'])->name('products');
    Route::get('/products/update/{id}', [AdminController::class, 'adminShowProductUpdateForm'])->name('products.update.show');
    Route::put('/products/update', [AdminController::class, 'adminProductUpdate'])->name('products.update');
    Route::get('/products/delete/{id}', [AdminController::class, 'adminProductsDelete'])->name('products.delete');
    Route::get('/customers', [AdminController::class, 'adminCustomers'])->name('customers');
});
// Admin routes ends

Route::get('/header', [HeaderController::class, 'index']);

// User profile route
Route::get('/user/profile', [UserController::class, 'index'])
    ->name('user-profile');

Route::get('/user/profile/change-email', [UserController::class, 'showUpdateEmailForm'])
    ->name('profile-email.reset');

Route::post('/user/profile/update-email', [UserController::class, 'updateEmail'])
    ->name('email.update');

Route::get('/user/profile/update-email/error', [UserController::class, 'updateEmailError'])
    ->name('email.error');

Route::get('/user/profile/update-email/error', function() {
        return view('auth.emails.email_updated_error');
    })->name('checkout.error');

// User bookings route
Route::get('/user/bookings', [UserController::class, 'userBookings'])
    ->name('user-bookings');

Route::middleware([LocaleMiddleware::class])->group(function() {
    Route::get('/language/{locale}', [LanguageController::class, 'switchLanguage'])
        ->name('language.switch');
});

// Products route
Route::get('products/products-single/{id}', [ProductsController::class, 'singleProduct'])
    ->name('product.single');
Route::post('/add-to-cart/{productId}', [CartController::class, 'addToCart'])
    ->name('add.cart');

// Cart routes
Route::get('/products/cart', [CartController::class, 'index'])
    ->name('cart');
Route::get('products/cart/remove/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');
Route::post('/products/cart/insert', [CartController::class, 'prepareCart'])
    ->name('prepare.cart');

// Apply middleware to checkout routes
Route::post('/stripe/process', [StripeController::class, 'processPayment'])->name('stripe.process');
Route::post('/stripe/create-payment-intent', [StripeController::class, 'createPaymentIntent'])->name('stripe.createPaymentIntent');
Route::middleware([CheckCartNotEmpty::class])->group(function () {
    Route::match(['get', 'post'], '/products/checkout', [CartController::class, 'cartCheckout'])
        ->name('cart.checkout');
    Route::match(['get', 'post'], '/checkout/process', [CheckoutController::class, 'insertCheckout'])
        ->name('insert.checkout');

    // Corrected anonymous function route
    Route::get('/checkout/error', function() {
        return view('products.checkout.error');
    })->name('checkout.error');

    // Route::get('/products/payment', [CheckoutController::class, 'payment'])
    //     ->name('payment');
    // web.php
    Route::get('/products/payment/{gateway}', [CheckoutController::class, 'payment'])->name('payment');
    Route::get('/products/success', [CheckoutController::class, 'success'])
        ->name('products.payment.success');

    Route::get('/payment/error', function () {
        return view('products.error');
    })->name('payment.error');
});

Route::get('/states/{country}', [CheckoutController::class, 'getStates']);
// Menu routes
Route::get('/ourMenu', [MenuController::class, 'index'])
    ->name('menu');
Route::get('/desserts', [ProductsController::class, 'showDesserts'])
    ->name('desserts');
Route::get('/drinks', [ProductsController::class, 'showDrinks'])
    ->name('drinks');

// Services route
Route::get('/services', [ServicesController::class, 'index'])->name('services');

// Contact routes
Route::get('/contactUs', [ContactController::class, 'index'])
    ->name('contact');
Route::post('/contactUs', [ContactController::class, 'contact'])
    ->name('contact');

// About routes
Route::get('/aboutUs', [AboutController::class, 'index'])
    ->name('about');

// Gallery routes
Route::get('/gallery', [GalleryController::class, 'index'])
    ->name('gallery');

// Bookings route
Route::get('/booking/success', [BookingController::class, 'successfulBooking'])
    ->name('booking.success');
    // ->middleware(['auth', 'checkBookingNotEmpty']); // Adjust middleware alias if necessary

Route::post('/booking', [BookingController::class, 'insertBooking'])
    ->name('booking.insert');

Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'es', 'fr'])) {
        abort(400);
    }

    App::setLocale($locale);

    // ...
});

?>
