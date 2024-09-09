<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions\Database;

use Thehouseofel\Hexagonal\Domain\Exceptions\Base\BasicException;

final class HasRelationException extends BasicException
{
    const STATUS_CODE = 409; // HTTP_CONFLICT;
}
