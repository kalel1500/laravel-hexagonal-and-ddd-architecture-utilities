<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * Service routes
 */
Route::get('/ajax/check-service-queues',        [\Thehouseofel\Hexagonal\Infrastructure\Controllers\Ajax\AjaxQueuesController::class, 'checkService'])->name('ajax.queues.checkService');
Route::get('/ajax/check-service-websockets',    [\Thehouseofel\Hexagonal\Infrastructure\Controllers\Ajax\AjaxWebsocketsController::class, 'checkService'])->name('ajax.websockets.checkService');

/**
 * Queues routes
 */
Route::get('/queues/jobs',                      [\Thehouseofel\Hexagonal\Infrastructure\Controllers\Web\JobsController::class, 'queuedJobs'])->name('queues.queuedJobs');
Route::get('/queues/failed-jobs',               [\Thehouseofel\Hexagonal\Infrastructure\Controllers\Web\JobsController::class, 'failedJobs'])->name('queues.failedJobs');
Route::get('/ajax/queues/jobs',                 [\Thehouseofel\Hexagonal\Infrastructure\Controllers\Ajax\AjaxJobsController::class, 'getJobs'])->name('ajax.queues.getJobs');
Route::get('/ajax/queues/failed-jobs',          [\Thehouseofel\Hexagonal\Infrastructure\Controllers\Ajax\AjaxJobsController::class, 'getFailedJobs'])->name('ajax.queues.getFailedJobs');

/**
 * Test routes
 */
Route::get('/test',                             [\Thehouseofel\Hexagonal\Infrastructure\Controllers\Web\TestController::class, 'test'])->name('test');

/**
 * Layout routes
 */
// Definir una ruta para servir los assets del paquete
Route::get('/public/assets/{file}',             [\Thehouseofel\Hexagonal\Infrastructure\Controllers\Web\LayoutController::class, 'public'])
    ->where('file', '.*')
    ->name('public');