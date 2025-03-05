<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\TimestampNullVo;

final class ModelTimestampNull extends TimestampNullVo
{
    protected const IS_MODEL = true;
}
