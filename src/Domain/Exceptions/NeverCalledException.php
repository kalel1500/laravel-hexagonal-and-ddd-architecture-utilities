<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

use Throwable;

final class NeverCalledException extends BasicException
{
    const DEFAULT_CODE = 500;
    const DEFAULT_MESSAGE = 'This part of the code should never be executed.';

    public function __construct(
        ?string $message = null,
        ?int $code = null,
        ?Throwable $previous = null
    )
    {
        $message = 'INTERNAL ERROR: '.$message;
        parent::__construct($message, $code, null, false, $previous); // TODO PHP8 - Named params (pasar solo el $previous)
    }
}
