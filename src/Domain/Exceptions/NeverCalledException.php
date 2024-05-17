<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

use Throwable;

final class NeverCalledException extends BasicException
{
    /**
     * BasicException constructor.
     * @param string|array $message
     * @param int|null $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", int $code = null, Throwable $previous = null)
    {
        $code = (is_null($code)) ? HTTP_INTERNAL_SERVER_ERROR() : $code;
        parent::__construct($message, $code, [], false, $previous);
    }
}
