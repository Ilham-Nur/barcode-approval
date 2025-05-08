<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/',[LoginController::class, 'index'])->name('page.login');
Route::post('/ajax-login', [LoginController::class, 'ajaxLogin'])->name('ajax.login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
