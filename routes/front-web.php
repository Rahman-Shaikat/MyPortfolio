<?php

use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
