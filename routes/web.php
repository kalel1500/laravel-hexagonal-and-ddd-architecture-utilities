<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\AjaxJobsController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\AjaxQueuesController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\AjaxWebsocketsController;


Route::get('/ajax/check-service-queues',        [AjaxQueuesController::class, 'checkService'])->name('hexagonal.ajax.queues.checkService');
Route::get('/ajax/check-service-websockets',    [AjaxWebsocketsController::class, 'checkService'])->name('hexagonal.ajax.websockets.checkService');

Route::get('/ajax/queues/jobs',                 [AjaxJobsController::class, 'getJobs'])->name('hexagonal.ajax.queues.getJobs');
Route::get('/ajax/queues/failed-jobs',          [AjaxJobsController::class, 'getFailedJobs'])->name('hexagonal.ajax.queues.getFailedJobs');
