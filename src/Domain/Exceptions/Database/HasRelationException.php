<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions\Database;

use Thehouseofel\Hexagonal\Domain\Exceptions\Base\BasicException;

final class HasRelationException extends BasicException
{
    const STATUS_CODE = 409; // HTTP_CONFLICT;

    public function __construct(string $model, string $relation)
    {
        parent::__construct(__('h::database.record_is_used_in_relation', ['model' => $model, 'relation' => $relation]));
    }
}
