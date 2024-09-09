<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

use Thehouseofel\Hexagonal\Domain\Exceptions\Base\BasicException;
use Throwable;

final class NeverCalledException extends BasicException
{
    const STATUS_CODE = 500;

    public function __construct(?string $message = null, ?Throwable $previous = null)
    {
        parent::__construct('INTERNAL ERROR: '.$message, $previous);
    }
}
