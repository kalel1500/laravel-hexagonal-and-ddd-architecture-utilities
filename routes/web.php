<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\AjaxQueuesController;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\AjaxWebsocketsController;


Route::get('/ajax/check-service-queues',        [AjaxQueuesController::class, 'checkService'])->name('hexagonal.ajax.queues.checkService');
Route::get('/ajax/check-service-websockets',    [AjaxWebsocketsController::class, 'checkService'])->name('hexagonal.ajax.websockets.checkService');