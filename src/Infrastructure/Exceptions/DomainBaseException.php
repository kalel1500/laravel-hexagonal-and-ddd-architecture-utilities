<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use RuntimeException;
use Throwable;

abstract class DomainBaseException extends RuntimeException
{
    public $responseCode;
    public $jsonContent;

    /**
     * DomainBaseException constructor.
     * @param int $code
     * @param string $message
     * @param array $data
     * @param bool $success
     * @param Throwable|null $previous
     */
    public function __construct(int $code, string $message, array $data, bool $success = false, Throwable $previous = null)
    {
        // Llamar al constructor
        parent::__construct($message, $code, $previous);

        // Establecer la excepción
        $e = ($previous instanceof Throwable) ? $previous : $this;
        $exceptionData = getExceptionData($e, $data, $success);

        // Guardar código y montar estructura del Json a devolver // INFO kalel1500 - mi_estructura_de_respuesta
        $this->responseCode                 = $exceptionData->code();
        $this->jsonContent['success']       = $exceptionData->success();
        $this->jsonContent['message']       = $exceptionData->message();
        $this->jsonContent['data']          = $exceptionData->data();
        if (appIsInDebugMode()) {
            $this->jsonContent['exception'] = $exceptionData->exception();
            $this->jsonContent['file']      = $exceptionData->file();
            $this->jsonContent['line']      = $exceptionData->line();
            $this->jsonContent['trace']     = collect($exceptionData->trace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all();
        }
    }

    /**
     * @param  Request  $request
     * @return JsonResponse|Response|null
     */
    public function render(Request $request)
    {
        if ($request->expectsJson() || urlContainsAjax()) {
            return response()->json($this->jsonContent, $this->responseCode);
        }

        if (appIsInDebugMode()) {
            return null;
        }

        $viewData = [
            'data' => $this->jsonContent,
            'code' => $this->responseCode,
            'message' => $this->jsonContent['message']
        ];
        return response()->view('hexagonal::custom-error', $viewData, $this->responseCode);

    }
}
