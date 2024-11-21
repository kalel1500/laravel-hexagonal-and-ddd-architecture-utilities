<?php

use Illuminate\Support\Facades\Route;
use Src\Shared\Infrastructure\DefaultController;

/**
 * Ruta original de Laravel para la vista welcome
 */
Route::get('/welcome', fn() => view('welcome'));

/**
 * Rutas de la aplicación
 */
Route::get('/', fn() => redirect()->route('home'));
Route::get('/home', [DefaultController::class, 'home'])->name('home');
