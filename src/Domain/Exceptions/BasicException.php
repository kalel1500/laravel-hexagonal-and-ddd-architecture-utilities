<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

use Thehouseofel\Hexagonal\Infrastructure\Exceptions\DomainBaseException;
use Throwable;

abstract class BasicException extends DomainBaseException
{
    const DEFAULT_CODE = 400;
    const DEFAULT_MESSAGE = 'An error occurred while processing your request.';

    /**
     * BasicException constructor.
     * @param string|null $message
     * @param int|null $code
     * @param array|null $data
     * @param bool $success
     * @param Throwable|null $previous
     */
    public function __construct(
        ?string $message = null,
        ?int $code = null,
        ?array $data = null,
        bool $success = false,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message ?? static::DEFAULT_MESSAGE, $code ?? static::DEFAULT_CODE, $data, $success, $previous);
    }
}
