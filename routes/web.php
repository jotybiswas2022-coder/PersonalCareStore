<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Frontend\ContactMessageController;
use App\Http\Controllers\Frontend\ToLetAdvertisementController as FrontendToLetController;
use App\Http\Controllers\Admin\ToLetAdvertisementController as AdminToLetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;

/*
|--------------------------------------------------------------------------
| Public Routes (No Auth Required)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Contact Messages (Public)
|--------------------------------------------------------------------------
*/
Route::post('/contact/submit', [ContactMessageController::class, 'store'])->name('contact.submit');
Route::get('/contact/find', [ContactMessageController::class, 'find'])->name('contact.find');
Route::get('/contact/message/{token}', [ContactMessageController::class, 'show'])->name('contact.message');

/*
|--------------------------------------------------------------------------
| To-Let Advertisement (Public)
|--------------------------------------------------------------------------
*/
Route::get('/to-let/post', [FrontendToLetController::class, 'create'])->name('to-let.create');
Route::post('/to-let/post', [FrontendToLetController::class, 'store'])->name('to-let.store');

/*
|--------------------------------------------------------------------------
| BasaFinder Frontend Pages
|--------------------------------------------------------------------------
*/
Route::get('/search', [FrontendToLetController::class, 'search'])->name('search');
Route::get('/property/{id}', [FrontendToLetController::class, 'show'])->name('property-detail');
Route::get('/post-property', [FrontendToLetController::class, 'postProperty'])->name('post-property');
Route::post('/post-property', [FrontendToLetController::class, 'storePostProperty'])->name('post-property.store');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // My Properties
    Route::get('/my-properties', [FrontendToLetController::class, 'myProperties'])->name('my-properties');
    Route::get('/my-properties/{id}/edit', [FrontendToLetController::class, 'editProperty'])->name('my-properties.edit');
    Route::put('/my-properties/{id}', [FrontendToLetController::class, 'updateProperty'])->name('my-properties.update');
    Route::delete('/my-properties/{id}', [FrontendToLetController::class, 'destroyProperty'])->name('my-properties.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Auth Required + Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Settings Management
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Contact Messages
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{id}/reply', [AdminMessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{id}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

    // Testimonials
    Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('/testimonials/create', [AdminTestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('/testimonials', [AdminTestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('/testimonials/{id}/edit', [AdminTestimonialController::class, 'edit'])->name('testimonials.edit');
    Route::put('/testimonials/{id}', [AdminTestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{id}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // FAQs
    Route::get('/faqs', [AdminFaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/create', [AdminFaqController::class, 'create'])->name('faqs.create');
    Route::post('/faqs', [AdminFaqController::class, 'store'])->name('faqs.store');
    Route::get('/faqs/{id}/edit', [AdminFaqController::class, 'edit'])->name('faqs.edit');
    Route::put('/faqs/{id}', [AdminFaqController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{id}', [AdminFaqController::class, 'destroy'])->name('faqs.destroy');

    // To-Let Advertisements
    Route::get('/to-let', [AdminToLetController::class, 'index'])->name('to-let.index');
    Route::get('/to-let/create', [AdminToLetController::class, 'create'])->name('to-let.create');
    Route::post('/to-let', [AdminToLetController::class, 'store'])->name('to-let.store');
    Route::get('/to-let/{id}/edit', [AdminToLetController::class, 'edit'])->name('to-let.edit');
    Route::put('/to-let/{id}', [AdminToLetController::class, 'update'])->name('to-let.update');
    Route::delete('/to-let/{id}', [AdminToLetController::class, 'destroy'])->name('to-let.destroy');
    Route::post('/to-let/{id}/approve', [AdminToLetController::class, 'approve'])->name('to-let.approve');
    Route::post('/to-let/{id}/reject', [AdminToLetController::class, 'reject'])->name('to-let.reject');
});

// Include auth routes from Breeze
require __DIR__.'/auth.php';
