<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

use Thehouseofel\Hexagonal\Domain\Exceptions\Base\BasicException;

final class UnexpectedLogicException extends BasicException
{
    const STATUS_CODE = 500; // HTTP_INTERNAL_SERVER_ERROR
}
