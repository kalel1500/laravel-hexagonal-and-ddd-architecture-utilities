<?php

use Illuminate\Support\Facades\Route;
use Src\Dashboard\Infrastructure\Http\Controllers\DashboardController;
use Src\Shared\Infrastructure\Http\Controllers\DefaultController;

/**
 * Ruta original de Laravel para la vista welcome
 */

Route::get('/welcome', fn() => view('welcome'))->name('welcome');

/**
 * Rutas de la aplicación
 */

// Ruta base
Route::redirect('/', '/home');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/home',         [DefaultController::class, 'home'])->name('home');
    Route::get('/dashboard',    [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/posts/{slug}', [DashboardController::class, 'post'])->name('post');
});
