<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions\Base;

use Throwable;

abstract class BasicException extends DomainException
{
    const STATUS_CODE = 500;

    public function __construct(
        string     $message = "",
        ?Throwable $previous = null,
        int        $code = 0,
        ?array     $data = null,
        bool       $success = false
    )
    {
        parent::__construct(static::STATUS_CODE, $message, $previous, $code, $data, $success);
    }
}
