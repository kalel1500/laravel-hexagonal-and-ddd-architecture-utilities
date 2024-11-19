<?php

use Illuminate\Support\Facades\Route;
use Src\Home\Infrastructure\HomeController;

/**
 * Ruta original de Laravel para la vista welcome
 */
Route::get('/welcome', function() { return view('welcome'); });

/**
 * Rutas de la aplicación
 */
Route::get('/', function() { return redirect()->route('home'); });
Route::get('/home', [HomeController::class, 'index'])->name('home.index');
