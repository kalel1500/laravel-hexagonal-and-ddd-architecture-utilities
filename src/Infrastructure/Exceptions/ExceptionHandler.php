<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Thehouseofel\Hexagonal\Domain\Exceptions\AbortException;
use Thehouseofel\Hexagonal\Domain\Exceptions\Base\BasicHttpException;
use Thehouseofel\Hexagonal\Domain\Exceptions\Base\HexagonalException;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ExceptionContextDo;
use Throwable;

final class ExceptionHandler
{
    /**
     * Internamente Laravel primero llama al render()
     *
     * Después llama al respond() y este modifica la respuesta
     *
     * @return callable
     */
    public static function getUsingCallback(): callable
    {
        return function (Exceptions $exceptions) {

            // Renderizar manualmente los ModelNotFoundException para que todos los "findOrFail()" en local muestren la vista "trace" y en PRO muestren nuestra vita "custom-error" sin tener que envolverlos en un "tryCatch"
            $exceptions->render(function (NotFoundHttpException $e, Request $request) {
                $exception = $e->getPrevious();

                // Si no es una instancia de ModelNotFoundException, devolver null
                if (!($exception instanceof ModelNotFoundException)) return null;

                if (debugIsActive()) {
                    return getLaravelTraceDebugResponse($request, $exception);
                } else {
                    $context = ExceptionContextDo::from($exception);
                    return response()->view('hexagonal::pages.exceptions.error', compact('context'), $context->getStatusCode());
                }
            });

            // Renderizar nuestras excepciones de dominio
            $exceptions->render(function (HexagonalException $e, Request $request) {
                $context = $e->getContext();

                // Si se espera un Json, pasarle todos los datos de nuestra "HexagonalException" [success, message, data]
                if ($request->expectsJson() || urlContainsAjax()) {
                    return response()->json($context->toArray(), $context->getStatusCode());
                }

                // Si espera una Vista y comprobamos si el debug es true
                if (debugIsActive()) {
                    // Si la excepción es una instancia de "AbortException" renderizamos la vista de errores de Laravel
                    if ($e instanceof AbortException) return getLaravelTraceDebugResponse($request, $e);

                    // Para cualquier "HexagonalException" que no sea "BasicHttpException", dejamos que laravel se encargue de renderizar el error.
                    if (!($e instanceof BasicHttpException)) return null;
                }

                // En PROD (o las "BasicHttpException" en DEBUG) devolvemos nuestra vista personalizada
                return response()->view('hexagonal::pages.exceptions.error', compact('context'), $context->getStatusCode());
            });

            // Indicar a Laravel cuando devolver un Json (mirar url "/ajax/")
            $exceptions->shouldRenderJsonWhen(function ($request, Throwable $e) {
                return $request->expectsJson() || urlContainsAjax();
            });

            // Formatear todas las respuestas Json para añadir los parámetros [success, message, data] con un valor por defecto (No aplica en los "HexagonalException" porque ya tienen ese formato)
            $exceptions->respond(function (Response $response, Throwable $e, Request $request) {
                if ($response instanceof JsonResponse) {
                    $data = json_decode($response->getContent(), true);
                    $data = array_merge(['success' => false, 'message' => '', 'data' => null], $data);
                    return response()->json($data, $response->getStatusCode());
                }
                return $response;
            });

        };
    }
}