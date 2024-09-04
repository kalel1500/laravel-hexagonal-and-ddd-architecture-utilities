<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\DateNullVo;

final class ModelDateNull extends DateNullVo
{
    protected const IS_MODEL = true;
}
