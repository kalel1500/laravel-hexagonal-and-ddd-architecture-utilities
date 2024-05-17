<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

use Thehouseofel\Hexagonal\Infrastructure\Exceptions\DomainBaseException;
use Throwable;

abstract class BasicException extends DomainBaseException
{
    /**
     * BasicException constructor.
     * @param string $message
     * @param int|null $code
     * @param array $data
     * @param bool $success
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = null, array $data = [], bool $success = false, Throwable $previous = null)
    {
        $code = (is_null($code)) ? HTTP_BAD_REQUEST() : $code;
        parent::__construct($code, $message, $data, $success, $previous);
    }
}
