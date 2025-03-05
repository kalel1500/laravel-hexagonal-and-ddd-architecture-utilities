<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions\Base;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class BasicHttpException extends KalionException implements HttpExceptionInterface
{
    const STATUS_CODE = 500;
    const MESSAGE = '';

    public function __construct(
        ?int        $statusCode = null,
        ?string     $message = null,
        ?Throwable $previous = null,
        ?array     $data = null,
        bool       $success = false,
        int        $code = 0
    )
    {
        $statusCode = $statusCode ?? static::STATUS_CODE;
        $message = $message ?? static::MESSAGE;
        parent::__construct($statusCode, $message, $previous, $code, $data, $success);
    }

    public function getHeaders(): array
    {
        return [];
    }
}
