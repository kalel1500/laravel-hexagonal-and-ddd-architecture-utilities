<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

use Thehouseofel\Hexagonal\Domain\Exceptions\Base\DomainException;
use Throwable;

final class GeneralException extends DomainException
{
    public function __construct(
        int        $statusCode = 500,
        string     $message = "",
        ?Throwable $previous = null,
        ?array     $data = null,
        bool       $success = false
    )
    {
        parent::__construct($statusCode, $message, $previous, 0, $data, $success);
    }
}
