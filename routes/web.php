<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //category routes
    Route::resource('category', CategoryController::class);

    //product routes
    Route::resource('products', ProductController::class);
    Route::get('/view-products', [ProductController::class, 'viewProducts'])->name('products.viewProducts');
    Route::get('/product/{id}', [ProductController::class, 'getProduct'])->name('product.get');
    Route::get('/export-products', [ProductController::class, 'exportProducts'])->name('products.export');

    //cart routes
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    //wishlist routes
    Route::post('/favorite/add', [WishlistController::class, 'addToFavorite']);
    Route::get('/favorites', [WishlistController::class, 'viewFavorites'])->name('favorites.view');

//    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Route for the greeting page
//    Route::get('/greeting', function () {
//        return view('cart.greeting-page');
//    })->name('greeting.page');

    //checkout for cart
    Route::post('/checkout', [StripePaymentController::class, 'checkout'])->name('checkout');
    Route::get('/success', [StripePaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/cancel', [StripePaymentController::class, 'paymentCancel'])->name('payment.cancel');

    //for sending sms
    Route::get('/send-sms', [SMSController::class, 'showForm'])->name('sms.form');
    Route::post('/send-sms', [SMSController::class, 'sendSms'])->name('sms.send');

    //for otp verification
    Route::get('/otp-form', function () {
        return view('sms.send_otp');
    })->name('otp.form');
    Route::get('/verify-otp', function () {
        return view('sms.verify_otp');
    })->name('verify.form');
    Route::post('/send-otp', [SMSController::class, 'sendOtp']);
    Route::post('/verify-otp', [SMSController::class, 'verifyOtp']);

});




require __DIR__.'/auth.php';
