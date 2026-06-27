<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AccountController;
use App\Http\Controllers\admin\ContactController;


Route::prefix('/admin')->middleware('admin')->group(function () {

    // Dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index');
    });

    //Account
    Route::prefix('/account')->controller(AccountController::class)->group(function () {
        Route::get('/', 'index');               
        Route::get('/edit',  'edit');
        Route::post('/update', 'update');
    });

     // Contact
    Route::prefix('/contact')->controller(ContactController::class)->group(function () {
        Route::get('/', 'index');
    });
});