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

            // Indicar a Laravel cuando devolver un Json (mirar url "/ajax/")
            $exceptions->shouldRenderJsonWhen(function ($request, Throwable $e) {
                return $request->expectsJson() || urlContainsAjax();
            });

            // Sobreescribir todas las respuestas Json para indicar estructura [success, message, data]
            $exceptions->respond(function (Response $response, Throwable $e, Request $request) {
                if ($response instanceof JsonResponse) {
                    $data = json_decode($response->getContent(), true);
                    $data = array_merge(['success' => false, 'message' => '', 'data' => null], $data);
                    return response()->json($data, $response->getStatusCode());
                }
                return $response;
            });

            // Renderizar nuestras excepciones de dominio
            $exceptions->render(function (DomainBaseException $e, Request $request) {

                // Comprobar si hay que devolver un json
                if ($request->expectsJson() || urlContainsAjax()) {
                    return response()->json($e->exceptionData->toArray(), $e->exceptionData->code());
                }

                if (appIsInDebugMode()) {
                    return null;
                }

                return response()->view('hexagonal::custom-error', [
                    'code'    => $e->exceptionData->code(),
                    'message' => $e->exceptionData->message(),
                    'data'    => $e->exceptionData->data(),
                ], $e->exceptionData->code());
            });
        };
    }
}