<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax\AjaxCookiesController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax\AjaxJobsController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax\AjaxQueuesController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax\AjaxWebsocketsController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Web\AuthController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Web\ExampleController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Web\JobsController;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Web\HexagonalController;

Route::get('/hexagonal/root', [HexagonalController::class, 'root'])
    ->name('hexagonal.root');

Route::get('/hexagonal/sessions',  [HexagonalController::class, 'sessions'])
    ->name('hexagonal.sessions');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'store']);
});

Route::middleware('auth')->group(function () {

    Route::post('logout', [AuthController::class, 'destroy'])
        ->name('logout');

    // Service routes
    Route::get('/hexagonal/ajax/check-service-queues', [AjaxQueuesController::class, 'checkService'])
        ->name('hexagonal.ajax.queues.checkService');

    Route::get('/hexagonal/ajax/check-service-websockets', [AjaxWebsocketsController::class, 'checkService'])
        ->name('hexagonal.ajax.websockets.checkService');

    // Queues routes
    Route::get('/hexagonal/queues/jobs', [JobsController::class, 'queuedJobs'])
        ->name('hexagonal.queues.queuedJobs');

    Route::get('/hexagonal/queues/failed-jobs', [JobsController::class, 'failedJobs'])
        ->name('hexagonal.queues.failedJobs');

    Route::get('/hexagonal/ajax/queues/jobs', [AjaxJobsController::class, 'getJobs'])
        ->name('hexagonal.ajax.queues.getJobs');

    Route::get('/hexagonal/ajax/queues/failed-jobs', [AjaxJobsController::class, 'getFailedJobs'])
        ->name('hexagonal.ajax.queues.getFailedJobs');


    // Cookies routes
    Route::put('/hexagonal/cookie/update', [AjaxCookiesController::class, 'update'])
        ->name('hexagonal.ajax.cookie.update');

    // Example routes
    Route::get('/hexagonal/example/example-1', [ExampleController::class, 'example1'])
        ->name('hexagonal.example1');

    Route::get('/hexagonal/example/example-2', [ExampleController::class, 'example2'])
        ->name('hexagonal.example2');

    Route::get('/hexagonal/example/example-3', [ExampleController::class, 'example3'])
        ->name('hexagonal.example3');

    Route::get('/hexagonal/example/example-4', [ExampleController::class, 'example4'])
        ->name('hexagonal.example4');

    Route::get('/hexagonal/example/compare-html', [ExampleController::class, 'compareHtml'])
        ->name('hexagonal.compareHtml');

    Route::get('/hexagonal/example/modify-cookie', [ExampleController::class, 'modifyCookie'])
        ->name('hexagonal.modifyCookie');

    Route::get('/hexagonal/example/icons', [ExampleController::class, 'icons'])
        ->name('hexagonal.icons');
});