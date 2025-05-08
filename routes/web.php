<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/',[LoginController::class, 'index'])->name('page.login');
Route::get('/dashboard', [DashboardController::class, 'index']);
