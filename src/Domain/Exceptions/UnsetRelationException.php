<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

final class UnsetRelationException extends BasicException
{
    public function __construct(string $relation = '', string $entity = '')
    {
        parent::__construct(sprintf('Call to relation [%s] that was not set when creating Entity [%s]', $relation, $entity), HTTP_INTERNAL_SERVER_ERROR());
    }
}
