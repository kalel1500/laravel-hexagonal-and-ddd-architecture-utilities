<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions\Base;

use RuntimeException;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ExceptionContextDo;
use Throwable;

abstract class HexagonalException extends RuntimeException
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
        // Llamar al constructor
        parent::__construct($message, $code, $previous);

        // Guardar el statusCode
        $this->statusCode = $statusCode;

        // Guardar código y montar estructura del Json a devolver // INFO kalel1500 - mi_estructura_de_respuesta
        $this->context = ExceptionContextDo::from($this, $data, $success);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContext(): ?ExceptionContextDo
    {
        return $this->context;
    }
}
