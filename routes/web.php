<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/ajax-login', [LoginController::class, 'ajaxLogin'])->name('ajax.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('projects', ProjectController::class);
    Route::patch('/projects/{project}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
    Route::patch('/projects/{project}/reject', [ProjectController::class, 'reject'])->name('projects.reject');
    Route::post('/projects/generate-barcode', [ProjectController::class, 'generateBarcode'])->name('projects.generate-barcode');
    Route::get('/projects/barcode/{id}', [ProjectController::class, 'getBarcode'])->name('projects.get-barcode');


    Route::resource('statuses', \App\Http\Controllers\ProjectStatusController::class);
});


Route::get('/project/card/{id}', [ProjectController::class, 'showCard'])->name('projects.show.card');
