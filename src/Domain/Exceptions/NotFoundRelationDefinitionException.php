<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

final class NotFoundRelationDefinitionException extends BasicException
{
    public function __construct(string $relation = '', string $entity = '')
    {
        parent::__construct(sprintf('Call to undefined relationship [%s] on repository data [%s]', $relation, $entity), HTTP_INTERNAL_SERVER_ERROR());
    }
}
