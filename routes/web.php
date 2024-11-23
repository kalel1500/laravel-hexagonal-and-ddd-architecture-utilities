<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax\AjaxCookiesController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax\AjaxJobsController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax\AjaxQueuesController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax\AjaxWebsocketsController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Web\ExampleController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Web\JobsController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Web\HexagonalController;


/**
 * Base route
 */

Route::get('/root',                             [HexagonalController::class, 'root'])->name('root');


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
 * Cookies routes
 */

Route::put('/cookie/update',                    [AjaxCookiesController::class, 'update'])->name('ajax.cookie.update');


/**
 * Example routes
 */

Route::get('example/example-1',     [ExampleController::class, 'example1'])->name('example1');
Route::get('example/example-2',     [ExampleController::class, 'example2'])->name('example2');
Route::get('example/example-3',     [ExampleController::class, 'example3'])->name('example3');
Route::get('example/example-4',     [ExampleController::class, 'example4'])->name('example4');
Route::get('example/compare-html',  [ExampleController::class, 'compareHtml'])->name('compareHtml');
Route::get('example/modify-cookie', [ExampleController::class, 'modifyCookie'])->name('modifyCookie');
Route::get('example/icons',         [ExampleController::class, 'icons'])->name('icons');