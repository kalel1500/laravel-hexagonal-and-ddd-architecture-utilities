<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Infrastructure\Http\Controllers\Ajax;

use Illuminate\Http\JsonResponse;
use Thehouseofel\Kalion\Infrastructure\Http\Controllers\Controller;
use Thehouseofel\Kalion\Infrastructure\Events\EventCheckWebsocketsStatus;
use Thehouseofel\Kalion\Infrastructure\Services\WebsocketsService;
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
