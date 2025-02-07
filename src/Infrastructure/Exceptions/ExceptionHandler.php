<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Exceptions;

use Illuminate\Contracts\Foundation\ExceptionRenderer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Thehouseofel\Hexagonal\Domain\Exceptions\Base\HexagonalException;
use Thehouseofel\Hexagonal\Domain\Exceptions\Database\RecordNotFoundException;
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

            // Sobreescribir todos los ModelNotFoundException por DatabaseQueryException para que los metodos findOrFail() lanzen un error de dominio
            /*$exceptions->render(function (NotFoundHttpException $e, Request $request) {
                $exception = $e->getPrevious();
                if ($exception instanceof ModelNotFoundException) {
                    throw new RecordNotFoundException($exception->getMessage(), $exception);
                }
            });*/

            // Renderizar nuestras excepciones de dominio
            $exceptions->render(function (HexagonalException $e, Request $request) {
                $context = $e->getContext();

                // Comprobar si hay que devolver un json
                if ($request->expectsJson() || urlContainsAjax()) {
                    return response()->json($context->toArray(), $context->getStatusCode());
                }

                if (debugIsActive()) {
                    return null;
                    // $content = app(ExceptionRenderer::class)->render($e); // $context->previous()
                    // return response($content, $context->getStatusCode());
                }

                return response()->view('hexagonal::pages.custom-error', [
                    'code'    => $context->getStatusCode(),
                    'message' => $context->message(),
                    'data'    => $context->data(),
                ], $context->getStatusCode());
            });
        };
    }
}