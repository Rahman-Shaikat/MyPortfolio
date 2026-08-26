<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PublicationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->controller(AdminLoginController::class)->group(function (): void {
    Route::get('/', 'redirect')->name('index');
    Route::get('/login/U1GFG_45vj-ik7BD_VFji_khr0v', 'showLoginForm')->name('login');
    Route::post('/login/U1GFG_45vj-ik7BD_VFji_khr0v', 'login')->middleware('throttle:5,1')->name('login.store');
    Route::post('/logout', 'logout')->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware('admin.session')->group(function (): void {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('profiles', ProfileController::class)->except('show');
    Route::resource('projects', ProjectController::class)->except('show');
    Route::resource('publications', PublicationController::class)->except('show');
});
