<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Thehouseofel\Hexagonal\Domain\Exceptions\Base\DomainException;
use Throwable;

final class AbortException extends DomainException implements HttpExceptionInterface
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

    public function getHeaders(): array
    {
        return [];
    }
}
