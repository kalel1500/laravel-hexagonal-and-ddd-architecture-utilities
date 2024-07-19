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
    public $exceptionData;

    /**
     * DomainBaseException constructor.
     * @param int $code
     * @param string $message
     * @param array|null $data
     * @param bool $success
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message,
        int $code,
        ?array $data = null,
        bool $success = false,
        ?Throwable $previous = null
    )
    {
        // Llamar al constructor
        parent::__construct($message, $code, $previous);

        // Establecer la excepción
        $e = ($previous instanceof Throwable) ? $previous : $this;

        // Guardar código y montar estructura del Json a devolver // INFO kalel1500 - mi_estructura_de_respuesta
        $this->exceptionData = getExceptionData($e, $data, $success);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse|Response|null
     */
    public function render(Request $request)
    {
        if ($request->expectsJson() || urlContainsAjax()) {
            return response()->json($this->exceptionData->toArray(), $this->exceptionData->code());
        }

        if (appIsInDebugMode()) {
            return null;
        }

        return response()->view('hexagonal::custom-error', [
            'code'    => $this->exceptionData->code(),
            'message' => $this->exceptionData->message(),
            'data'    => $this->exceptionData->data(),
        ], $this->exceptionData->code());
    }
}
