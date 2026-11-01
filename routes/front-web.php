<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HabitTrackerController;
use App\Http\Controllers\Frontend\HabitTrackerPurchaseController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\LlmsController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\ResearchController;
use App\Http\Controllers\Frontend\ResumeController;
use App\Http\Controllers\Frontend\RobotsController;
use App\Http\Controllers\Frontend\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/habit-tracker', HabitTrackerController::class)->name('habit-tracker');
Route::get('/habit-tracker/purchase', [HabitTrackerPurchaseController::class, 'create'])->middleware('throttle:60,1')->name('habit-tracker.purchase');
Route::post('/habit-tracker/purchase', [HabitTrackerPurchaseController::class, 'store'])->middleware('throttle:6,1')->name('habit-tracker.purchase.store');
Route::get('/habit-tracker/purchase/confirmation', [HabitTrackerPurchaseController::class, 'confirmation'])->name('habit-tracker.purchase.confirmation');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/research', [ResearchController::class, 'index'])->name('research.index');
Route::get('/research/{slug}', [ResearchController::class, 'show'])->name('research.show');
Route::get('/resume/file', [ResumeController::class, 'file'])->name('resume.file');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:6,1')->name('contact.store');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');
Route::get('/llms.txt', LlmsController::class)->name('llms');
Route::get('/happy-birthday-to-you', [HomePageController::class, 'birthdayWish'])->name('birthday.wish');
