<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Session;

// Language Switch Route
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'bn'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back() ?: redirect('/');
})->name('language.switch');

Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'index');
});

Route::post('/contactus', [UserController::class, 'contactus']);

Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Auth::routes();

include('admin.php');
