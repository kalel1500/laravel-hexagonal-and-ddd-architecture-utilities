<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions\Base;

use Exception;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ExceptionContextDo;
use Throwable;

abstract class KalionException extends Exception
{
    protected $statusCode;
    protected $context;

    /**
     * DomainBaseException constructor.
     * @param int $statusCode
     * @param string $message
     * @param Throwable|null $previous
     * @param int $code
     * @param array|null $data
     * @param bool $success
     */
    public function __construct(
        int $statusCode = 500,
        string $message = "",
        ?Throwable $previous = null,
        int $code = 0,
        ?array $data = null,
        bool $success = false
    )
    {
        if ($message === "") {
            throw new Exception(__('h::error.exception_message_can_not_be_empty', ['exception' => static::class]));
        }

        // Llamar al constructor
        parent::__construct($message, $code, $previous);

        // Guardar el statusCode
        $this->statusCode = $statusCode;

        // Guardar código y montar estructura del Json a devolver // INFO kalel1500 - mi_estructura_de_respuesta
        $this->context = ExceptionContextDo::from($this, $data, $success, $this->getResponse($data));
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContext(): ?ExceptionContextDo
    {
        return $this->context;
    }

    public function getResponse($data): ?array
    {
        return null;
    }
}
