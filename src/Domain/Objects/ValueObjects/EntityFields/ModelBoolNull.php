<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\BoolNullVo;

final class ModelBoolNull extends BoolNullVo
{
    protected const IS_MODEL = true;
}
