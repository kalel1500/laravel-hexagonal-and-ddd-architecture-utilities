<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax;

use Illuminate\Http\JsonResponse;
use Thehouseofel\Hexagonal\Domain\Exceptions\ServiceException;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;
use Thehouseofel\Hexagonal\Infrastructure\Events\EventCheckQueuesStatus;
use Thehouseofel\Hexagonal\Infrastructure\Services\QueueService;
use Thehouseofel\Hexagonal\Infrastructure\Services\WebsocketsService;
use Throwable;

final class AjaxQueuesController extends Controller
{
    /**
     * @return JsonResponse
     * @throws Throwable
     */
    public function checkService(): JsonResponse
    {
        try {
            QueueService::check(__('queues_ServiceInactive'));
            $response = responseJson(true, __('queues_ServiceActive'));
        } catch (ServiceException $e) {
            $response = responseJson(false, $e->getMessage());
        } catch (Throwable $e) {
            $response = responseJsonError($e, false);
        }
        return WebsocketsService::emitEvent($response, new EventCheckQueuesStatus($response));
    }
}
