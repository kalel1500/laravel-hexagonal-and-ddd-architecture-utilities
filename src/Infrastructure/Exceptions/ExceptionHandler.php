<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ExceptionHandler
{
    public static function getUsingCallback(): callable
    {
        return function (Exceptions $exceptions) {
            $exceptions->respond(function (Response $response, Throwable $e, Request $request) {
                if ($response instanceof JsonResponse) {
                    $data = json_decode($response->getContent(), true);
                    $data = array_merge(['success' => false, 'message' => $data['message'], 'data' => null], $data);
                    return response()->json($data, $response->getStatusCode());
                }
                return $response;
            });
            $exceptions->shouldRenderJsonWhen(function ($request, Throwable $e) {
                return $request->expectsJson() || urlContainsAjax();
            });
        };
    }
}