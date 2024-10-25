<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Ajax\AjaxJobsController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Ajax\AjaxQueuesController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Ajax\AjaxWebsocketsController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Web\JobsController;

/**
 * Service routes
 */
Route::get('/ajax/check-service-queues',        [AjaxQueuesController::class, 'checkService'])->name('ajax.queues.checkService');
Route::get('/ajax/check-service-websockets',    [AjaxWebsocketsController::class, 'checkService'])->name('ajax.websockets.checkService');

/**
 * Queues routes
 */
Route::get('/queues/jobs',                      [JobsController::class, 'queuedJobs'])->name('queues.queuedJobs');
Route::get('/queues/failed-jobs',               [JobsController::class, 'failedJobs'])->name('queues.failedJobs');
Route::get('/ajax/queues/jobs',                 [AjaxJobsController::class, 'getJobs'])->name('ajax.queues.getJobs');
Route::get('/ajax/queues/failed-jobs',          [AjaxJobsController::class, 'getFailedJobs'])->name('ajax.queues.getFailedJobs');

/**
 * Test routes
 */
Route::get('/test',                             [\Thehouseofel\Hexagonal\Infrastructure\Controllers\Web\TestController::class, 'test'])->name('hexagonal.test');

/**
 * Layout routes
 */
// Definir una ruta para servir los assets del paquete
Route::get('/public/{type}/{file}',             [\Thehouseofel\Hexagonal\Infrastructure\Controllers\Web\LayoutController::class, 'public'])
    ->whereIn('type', ['js', 'css'])
    ->where('file', '.*')
    ->name('public');