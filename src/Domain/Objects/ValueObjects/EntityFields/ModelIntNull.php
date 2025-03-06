<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\IntNullVo;

final class ModelIntNull extends IntNullVo
{
    protected const IS_MODEL = true;
}
