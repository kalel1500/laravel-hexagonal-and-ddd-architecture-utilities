<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions\Database;

use Thehouseofel\Hexagonal\Domain\Exceptions\Base\BasicException;

final class UnsetRelationException extends BasicException
{
    const STATUS_CODE = 500; // HTTP_INTERNAL_SERVER_ERROR

    public function __construct(string $relation = '', string $entity = '')
    {
        parent::__construct(sprintf('Call to relation [%s] that was not set when creating Entity [%s]', $relation, $entity));
    }
}
