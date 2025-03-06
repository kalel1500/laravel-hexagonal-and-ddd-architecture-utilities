<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Exceptions\Database;

use Thehouseofel\Kalion\Domain\Exceptions\Base\BasicException;

final class RecordNotFoundException extends BasicException
{
    const STATUS_CODE = 404; // HTTP_NOT_FOUND
}
