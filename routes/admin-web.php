<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PublicationController;
use Illuminate\Support\Facades\Route;

Route::name('admin.')->controller(AdminLoginController::class)->group(function (): void {
    Route::get(config('admin.login_path'), 'showLoginForm')->name('login');
    Route::post(config('admin.login_path'), 'login')->middleware('throttle:5,1')->name('login.store');
});

Route::prefix('admin')->name('admin.')->middleware('admin.session')->group(function (): void {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::resource('profiles', ProfileController::class)->except('show');
    Route::resource('projects', ProjectController::class)->except('show');
    Route::resource('publications', PublicationController::class)->except('show');
});
