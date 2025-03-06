<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\DateNullVo;

final class ModelDateNull extends DateNullVo
{
    protected const IS_MODEL = true;
}
