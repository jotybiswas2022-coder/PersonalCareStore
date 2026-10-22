<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController as FrontendOrderController;
use App\Http\Controllers\Frontend\TrackOrderController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PaymentDetailController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfitLossController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Frontend\ContactMessageController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes (No Auth Required)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Uploaded media
|--------------------------------------------------------------------------
| Serves product, review and payment-proof images from the public disk so
| they work without relying on a storage symlink at the web root.
*/
Route::get('/media/{path}', function (string $path) {
    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    abort_unless($disk->exists($path), 404);

    return $disk->response($path, null, [
        'Cache-Control' => 'public, max-age=604800',
        'X-Content-Type-Options' => 'nosniff',
    ]);
})->where('path', '(?i)(products|reviews|proofs)/[A-Za-z0-9][A-Za-z0-9._-]*\.(jpe?g|png|webp|gif)')->name('media');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/category/{categoryId}', [ProductController::class, 'byCategory'])->name('products.byCategory');

/*
|--------------------------------------------------------------------------
| Order Tracking (Public - No Auth Required)
|--------------------------------------------------------------------------
*/
Route::get('/track-order', [TrackOrderController::class, 'index'])->name('track-order.index');
Route::post('/track-order/lookup', [TrackOrderController::class, 'lookup'])->name('track-order.lookup');
Route::get('/track-order/{id}', [TrackOrderController::class, 'show'])->name('track-order.show');

/*
|--------------------------------------------------------------------------
| Contact Messages (Public)
|--------------------------------------------------------------------------
*/
Route::post('/contact/submit', [ContactMessageController::class, 'store'])->name('contact.submit');
Route::get('/contact/my-messages', [ContactMessageController::class, 'myMessages'])->name('contact.my-messages');

/*
|--------------------------------------------------------------------------
| Cart Routes (Guest + Auth)
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{cartId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cartId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/delivery-area', [CartController::class, 'setDeliveryArea'])->name('cart.deliveryArea');

/*
|--------------------------------------------------------------------------
| Checkout Routes (Guest + Auth - No restriction)
|--------------------------------------------------------------------------
*/
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/checkout/success/{orderId}/proof', [CheckoutController::class, 'uploadProof'])->name('checkout.proof');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // My Orders
    Route::get('/orders', [FrontendOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [FrontendOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/cancel', [FrontendOrderController::class, 'cancel'])->name('orders.cancel');

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::match(['put', 'patch'], '/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::post('/reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
    Route::delete('/reviews/{review}/image', [ReviewController::class, 'deleteImage'])->name('reviews.deleteImage');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Auth Required + Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Product Management
    Route::resource('products', AdminProductController::class);

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Order Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::patch('/orders/{id}/approve-payment', [OrderController::class, 'approvePayment'])->name('orders.approvePayment');
    Route::patch('/orders/{id}/reject-payment', [OrderController::class, 'rejectPayment'])->name('orders.rejectPayment');

    // Settings Management
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Profit & Loss Report
    Route::get('/profit-loss', [ProfitLossController::class, 'index'])->name('profit-loss.index');

    // Contact Settings
    Route::get('/contact-setting', [ContactSettingController::class, 'index'])->name('contact-setting.index');
    Route::post('/contact-setting', [ContactSettingController::class, 'update'])->name('contact-setting.update');

    // Reviews
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');

    // Contact Messages
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{id}/reply', [AdminMessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{id}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

    // Payment Details Management
    Route::get('/payment-details', [PaymentDetailController::class, 'index'])->name('payment-details.index');
    Route::get('/payment-details/create', [PaymentDetailController::class, 'create'])->name('payment-details.create');
    Route::post('/payment-details', [PaymentDetailController::class, 'store'])->name('payment-details.store');
    Route::get('/payment-details/{paymentDetail}/edit', [PaymentDetailController::class, 'edit'])->name('payment-details.edit');
    Route::put('/payment-details/{paymentDetail}', [PaymentDetailController::class, 'update'])->name('payment-details.update');
    Route::delete('/payment-details/{paymentDetail}', [PaymentDetailController::class, 'destroy'])->name('payment-details.destroy');
});

// Include auth routes from Breeze
require __DIR__.'/auth.php';
