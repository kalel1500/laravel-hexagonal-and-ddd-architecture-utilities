<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\StringNullVo;

final class ModelStringNull extends StringNullVo
{
    protected const IS_MODEL = true;
}
