<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax;

use Illuminate\Http\JsonResponse;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;
use Thehouseofel\Hexagonal\Infrastructure\Events\EventCheckWebsocketsStatus;
use Thehouseofel\Hexagonal\Infrastructure\Services\WebsocketsService;
use Throwable;

final class AjaxWebsocketsController extends Controller
{
    /**
     * @return JsonResponse
     * @throws Throwable
     */
    public function checkService(): JsonResponse
    {
        $res = responseJson(true, 'Comprobado servicio websockets');
        return WebsocketsService::emitEvent($res, new EventCheckWebsocketsStatus());
    }
}
