<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\AjaxJobsController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\AjaxQueuesController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\AjaxWebsocketsController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\JobsController;

Route::get('/ajax/check-service-queues',        [AjaxQueuesController::class, 'checkService'])->name('ajax.queues.checkService');
Route::get('/ajax/check-service-websockets',    [AjaxWebsocketsController::class, 'checkService'])->name('ajax.websockets.checkService');

Route::get('/queues/jobs',                      [JobsController::class, 'queuedJobs'])->name('queues.queuedJobs');
Route::get('/queues/failed-jobs',               [JobsController::class, 'failedJobs'])->name('queues.failedJobs');
Route::get('/ajax/queues/jobs',                 [AjaxJobsController::class, 'getJobs'])->name('ajax.queues.getJobs');
Route::get('/ajax/queues/failed-jobs',          [AjaxJobsController::class, 'getFailedJobs'])->name('ajax.queues.getFailedJobs');

Route::get('/test',                             [\Thehouseofel\Hexagonal\Infrastructure\Controllers\TestController::class, 'test'])->name('hexagonal.test');
