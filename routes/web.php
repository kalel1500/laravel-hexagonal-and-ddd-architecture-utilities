<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Ajax\AjaxJobsController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Ajax\AjaxQueuesController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Ajax\AjaxWebsocketsController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Web\ExampleController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Web\JobsController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Web\HexagonalController;


/**
 * Test routes
 */

Route::get('/test-vite-package',                [HexagonalController::class, 'testVitePackage'])->name('test');


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
 * Example routes
 */

Route::get('example/example-1',     [ExampleController::class, 'example1'])->name('example1');
Route::get('example/example-2',     [ExampleController::class, 'example2'])->name('example2');
Route::get('example/example-3',     [ExampleController::class, 'example3'])->name('example3');
Route::get('example/example-4',     [ExampleController::class, 'example4'])->name('example4');
Route::get('example/compare-html',  [ExampleController::class, 'compareHtml'])->name('compareHtml');
