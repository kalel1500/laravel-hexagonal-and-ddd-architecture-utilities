<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

final class NotFoundRelationDataException extends BasicException
{
    public function __construct(string $relation = '')
    {
        parent::__construct(sprintf('La entidad no contiene datos de la relación seleccionada <%s>', $relation), HTTP_INTERNAL_SERVER_ERROR());
    }
}
