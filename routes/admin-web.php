<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\HabitTrackerOrderController;
use App\Http\Controllers\Admin\HabitTrackerPageController;
use App\Http\Controllers\Admin\HabitTrackerPaymentController;
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
    Route::patch('/projects/reorder', [ProjectController::class, 'reorder'])->name('projects.reorder');
    Route::resource('projects', ProjectController::class)->except('show');
    Route::resource('publications', PublicationController::class)->except('show');
    Route::get('/habit-tracker/page-info', [HabitTrackerPageController::class, 'edit'])->name('habit-tracker.edit');
    Route::put('/habit-tracker/page-info', [HabitTrackerPageController::class, 'update'])->name('habit-tracker.update');
    Route::get('/habit-tracker/orders', [HabitTrackerOrderController::class, 'index'])->name('habit-tracker.orders.index');
    Route::get('/habit-tracker/orders/{order}', [HabitTrackerOrderController::class, 'show'])->name('habit-tracker.orders.show');
    Route::patch('/habit-tracker/orders/{order}', [HabitTrackerOrderController::class, 'update'])->name('habit-tracker.orders.update');
    Route::get('/habit-tracker/orders/{order}/screenshot', [HabitTrackerOrderController::class, 'screenshot'])->name('habit-tracker.orders.screenshot');
    Route::get('/habit-tracker/payment-settings', [HabitTrackerPaymentController::class, 'edit'])->name('habit-tracker.payments.edit');
    Route::put('/habit-tracker/payment-settings', [HabitTrackerPaymentController::class, 'update'])->name('habit-tracker.payments.update');
});
