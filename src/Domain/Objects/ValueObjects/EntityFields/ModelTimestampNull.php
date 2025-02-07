<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\TimestampNullVo;

final class ModelTimestampNull extends TimestampNullVo
{
    protected const IS_MODEL = true;
}
